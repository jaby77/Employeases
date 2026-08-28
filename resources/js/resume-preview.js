import * as pdfjsLib from 'pdfjs-dist';
import workerUrl from 'pdfjs-dist/build/pdf.worker.min.mjs?url';

// Use the bundled worker so PDF parsing runs off the main thread.
pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;

const MIN_SCALE = 0.5;
const MAX_SCALE = 2;
const SCALE_STEP = 0.25;

let pdfDoc = null;
let scale = 1;
let loadPromise = null;
let renderToken = 0;

const byId = (id) => document.getElementById(id);

function setZoomEnabled(enabled) {
    byId('resumeZoomOut').disabled = !enabled;
    byId('resumeZoomIn').disabled = !enabled;
    byId('resumeZoomReset').disabled = !enabled;
}

function setLoading(loading) {
    byId('resumeLoading').classList.toggle('d-none', !loading);
}

function showError() {
    byId('resumeError').classList.remove('d-none');
    byId('resumePages').innerHTML = '';
}

function yieldToBrowser() {
    return new Promise(resolve => setTimeout(resolve, 0));
}

async function renderAllPages() {
    // Guard against interleaved renders (e.g. rapid zoom clicks): a stale render
    // aborts as soon as a newer one starts.
    const token = ++renderToken;
    const pagesEl = byId('resumePages');
    const viewportEl = byId('resumeViewport');
    pagesEl.innerHTML = '';
    viewportEl.scrollTop = 0;
    viewportEl.scrollLeft = 0;

    const dpr = window.devicePixelRatio || 1;

    // Progressive / first-page-first rendering: render page 1 immediately so
    // the user sees the document, then stream the remaining pages in with a
    // micro-yield between each so the UI thread never blocks — important for
    // multi-page resumes and slow devices.
    for (let i = 1; i <= pdfDoc.numPages; i++) {
        if (i > 1) {
            await yieldToBrowser();
        }
        if (token !== renderToken) return;

        const page = await pdfDoc.getPage(i);
        if (token !== renderToken) return;

        const cssViewport = page.getViewport({ scale });
        const renderViewport = page.getViewport({ scale: scale * dpr });

        const wrapper = document.createElement('div');
        wrapper.className = 'resume-page';
        wrapper.dataset.page = i;

        const canvas = document.createElement('canvas');
        canvas.width = Math.ceil(renderViewport.width);
        canvas.height = Math.ceil(renderViewport.height);
        canvas.style.width = `${Math.ceil(cssViewport.width)}px`;
        canvas.style.height = `${Math.ceil(cssViewport.height)}px`;

        wrapper.appendChild(canvas);
        pagesEl.appendChild(wrapper);

        await page.render({ canvasContext: canvas.getContext('2d'), viewport: renderViewport }).promise;
        if (token !== renderToken) return;

        // First page is on screen — drop the skeleton and announce it right
        // away, then stream the remaining pages in behind it.
        if (i === 1) {
            setLoading(false);
            updatePageIndicator(1);
        }
    }
}

function updatePageIndicator(current) {
    if (!pdfDoc) return;
    byId('resumePageIndicator').textContent = `Page ${Math.min(current, pdfDoc.numPages)} of ${pdfDoc.numPages}`;
}

function onViewportScroll() {
    if (!pdfDoc) return;
    const viewportEl = byId('resumeViewport');
    const pages = viewportEl.querySelectorAll('.resume-page');
    if (!pages.length) return;

    const probe = viewportEl.getBoundingClientRect().top + viewportEl.clientHeight * 0.35;
    let current = 1;
    for (const page of pages) {
        if (page.getBoundingClientRect().top <= probe) {
            current = parseInt(page.dataset.page, 10);
        } else {
            break;
        }
    }
    updatePageIndicator(current);
}

async function ensureLoaded(url) {
    if (pdfDoc) return;
    if (loadPromise) return loadPromise;

    setLoading(true);
    loadPromise = (async () => {
        const response = await fetch(url, {
            credentials: 'same-origin',
            headers: { Accept: 'application/pdf' },
        });
        if (!response.ok) {
            throw new Error(`Failed to fetch resume (HTTP ${response.status})`);
        }
        const data = await response.arrayBuffer();
        pdfDoc = await pdfjsLib.getDocument({ data }).promise;
        await renderAllPages();
        setZoomEnabled(true);
    })();

    try {
        await loadPromise;
    } catch (err) {
        console.error('Resume preview failed:', err);
        pdfDoc = null;
        loadPromise = null;
        setZoomEnabled(false);
        showError();
    } finally {
        setLoading(false);
    }
}

function setScale(next) {
    if (!pdfDoc) return;
    scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, next));
    byId('resumeZoomReset').textContent = `${Math.round(scale * 100)}%`;
    renderAllPages();
}

document.addEventListener('DOMContentLoaded', () => {
    const modal = byId('resumePreviewModal');
    if (!modal) return;

    const url = modal.dataset.resumeUrl;
    if (!url) return;

    byId('resumeZoomOut').addEventListener('click', () => setScale(scale - SCALE_STEP));
    byId('resumeZoomIn').addEventListener('click', () => setScale(scale + SCALE_STEP));
    byId('resumeZoomReset').addEventListener('click', () => setScale(1));
    byId('resumeViewport').addEventListener('scroll', onViewportScroll);

    modal.addEventListener('show.bs.modal', () => ensureLoaded(url));
});
