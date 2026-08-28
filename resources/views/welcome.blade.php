<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Municipal PESO Tagudin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="site-navbar navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-logo d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/employease-mark.webp') }}" alt="EmployEase logo" class="navbar-logo" width="50" height="50">
                <span class="navbar-wordmark fw-bold">EMPLOYEASE</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('jobseeker.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('jobseeker.jobs.index') }}">Browse Jobs</a></li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm fw-medium">Sign Out</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#jobs">Latest Jobs</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Sign In</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-brand-cta btn-sm fw-medium">Get Started</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-split">
        <div class="container">
            <div class="hero-split-inner">
                <div class="hero-text">
                    <span class="hero-badge mb-4">
                        <i class="bi bi-building"></i> Municipal PESO &bull; Tagudin, Ilocos Sur
                    </span>
                    <h1 class="hero-title mb-4">
                        Your Gateway to<br>
                        <span class="hero-accent">Employment Opportunities</span>
                    </h1>
                    <p class="hero-sub mb-5">
                        EMPLOYEASE connects job seekers with local employment opportunities in Tagudin, Ilocos Sur.
                        Find the perfect job or hire the right candidate through our municipal employment system.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @guest
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                                <i class="bi bi-person-plus me-2"></i>Create Account
                            </a>
                            <a href="{{ route('login') }}" class="btn-hero btn-hero-secondary">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </a>
                        @endguest
                        <a href="#jobs" class="btn-hero btn-hero-secondary">
                            <i class="bi bi-search me-2"></i>View Openings
                        </a>
                    </div>
                    <div class="stats-list mt-5">
                        <div class="stats-item">
                            <span class="stats-number">{{ $jobCount }}+</span>
                            <span class="stats-label">Job Vacancies</span>
                        </div>
                        <div class="stats-item">
                            <span class="stats-number">100+</span>
                            <span class="stats-label">Job Seekers</span>
                        </div>
                        <div class="stats-item">
                            <span class="stats-number">100%</span>
                            <span class="stats-label">Free Service</span>
                        </div>
                    </div>
                </div>
                <div class="hero-photo">
                    <img src="{{ asset('images/tagudin_town_hall.webp') }}" alt="Tagudin Municipal Hall" class="hero-photo-img" loading="eager" fetchpriority="high" width="1024" height="768">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary-emphasis mb-2 px-3 py-2">Features</span>
                <h2 class="fw-bold">Why Use EMPLOYEASE?</h2>
                <p class="text-muted">Connecting Tagudin's workforce with local employment opportunities</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px">
                                <i class="bi bi-search-heart fs-3"></i>
                            </div>
                            <h5 class="fw-semibold">Find Local Jobs</h5>
                            <p class="text-muted small">Browse employment opportunities within Tagudin and nearby areas. Search by category, type, or location.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px">
                                <i class="bi bi-file-text fs-3"></i>
                            </div>
                            <h5 class="fw-semibold">Easy Application</h5>
                            <p class="text-muted small">Apply for jobs with just a few clicks. Upload your resume and track your application status in real-time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px">
                                <i class="bi bi-bell fs-3"></i>
                            </div>
                            <h5 class="fw-semibold">Stay Updated</h5>
                            <p class="text-muted small">Receive notifications about your applications and stay informed about new job opportunities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jobs Section -->
    @if($featuredJobs->count() > 0)
        <section id="jobs" class="py-5 bg-light">
            <div class="container py-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-primary-subtle text-primary-emphasis mb-2 px-3 py-2">Latest Opportunities</span>
                        <h2 class="fw-bold mb-0">Featured Jobs</h2>
                    </div>
                    @auth
                        @if(auth()->user()->isJobSeeker())
                            <a href="{{ route('jobseeker.jobs.index') }}" class="btn btn-primary">View All Jobs</a>
                        @endif
                    @endauth
                </div>
                <div class="row g-3">
                    @foreach($featuredJobs as $job)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex mb-2">
                                        <span class="badge bg-primary-subtle text-primary-emphasis">{{ $job->category->name }}</span>
                                    </div>
                                    <h5 class="card-title fw-semibold mb-1">{{ $job->title }}</h5>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-building me-1"></i>{{ $job->company ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 small text-muted mb-3">
                                        <span><i class="bi bi-geo-alt me-1"></i>{{ $job->location }}</span>
                                        <span><i class="bi bi-clock me-1"></i>{{ $job->employment_type_label }}</span>
                                        @if($job->salary_min)
                                            <span class="text-primary-emphasis fw-medium">{{ $job->salary_formatted }}</span>
                                        @endif
                                    </div>
                                    @auth
                                        @if(auth()->user()->isJobSeeker())
                                            <a href="{{ route('jobseeker.jobs.show', $job) }}" class="btn btn-outline-primary btn-sm w-100">View Details</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">Sign in to Apply</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- About PESO -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 text-center">
                    <div class="rounded-4 overflow-hidden shadow-lg border position-relative" style="max-width: 320px; margin: 0 auto;">
                        <img src="{{ asset('images/tagudin_municipal_hall.webp') }}" alt="Tagudin Municipal Hall" class="img-fluid" loading="lazy" width="1280" height="960" style="object-fit: cover; height: 100%; opacity: 0.9;">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-gradient text-white p-3" style="background: linear-gradient(transparent, rgba(0,0,0,.6));">
                            <small class="fw-medium">Municipal Hall, Tagudin, Ilocos Sur</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <span class="badge bg-primary-subtle text-primary-emphasis mb-2 px-3 py-2">About PESO</span>
                    <h2 class="fw-bold mb-4">Municipal Public Employment Service Office</h2>
                    <p class="text-muted lead">
                        The PESO of Tagudin, Ilocos Sur is a frontline government service that provides 
                        employment assistance, labor market information, and facilitates the matching of 
                        job seekers with local employment opportunities. EMPLOYEASE is our digital platform 
                        designed to make employment services more accessible to all Tagudinians.
                    </p>
                    <div class="d-flex flex-wrap gap-4 mt-4">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-primary fs-4 mb-2"></i>
                            <div>
                                <small class="fw-medium text-dark">Location</small>
                                <p class="mb-0 text-muted small">Municipal Hall, Tagudin, Ilocos Sur</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-envelope-fill text-primary fs-4 mb-2"></i>
                            <div>
                                <small class="fw-medium text-dark">Email</small>
                                <p class="mb-0 text-muted small">peso@tagudin.gov.ph</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-telephone-fill text-primary fs-4 mb-2"></i>
                            <div>
                                <small class="fw-medium text-dark">Phone</small>
                                <p class="mb-0 text-muted small">(077) 674-1234</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-banner py-5">
        <div class="container py-4 text-center text-white position-relative">
            <h2 class="fw-bold mb-3">Ready to Find Your Next Job?</h2>
            <p class="lead opacity-90 mb-4">Join EMPLOYEASE today and take the first step towards your career.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-cta-gold btn-lg fw-semibold px-5">
                    <i class="bi bi-person-plus me-2"></i>Create Free Account
                </a>
            @else
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('jobseeker.jobs.index') }}"
                   class="btn btn-cta-gold btn-lg fw-semibold px-5">
                    <i class="bi bi-arrow-right me-2"></i>Go to Dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="footer-brand-logo">
                            <img src="{{ asset('images/employease-mark.webp') }}" alt="EmployEase logo" width="52" height="52">
                        </span>
                        <span class="footer-wordmark fw-bold">EMPLOYEASE</span>
                    </div>
                    <p class="footer-muted small mb-0">A Web-Based Employment Management System for the Municipal PESO of Tagudin, Ilocos Sur.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold">Quick Links</h6>
                    <ul class="list-unstyled small footer-muted">
                        <li class="mb-1"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                        @guest
                            <li class="mb-1"><a href="{{ route('login') }}" class="text-decoration-none">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="text-decoration-none">Register</a></li>
                        @endguest
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold">Contact</h6>
                    <ul class="list-unstyled small footer-muted footer-contact">
                        <li class="mb-1"><i class="bi bi-geo-alt me-1"></i>Tagudin, Ilocos Sur</li>
                        <li class="mb-1"><i class="bi bi-envelope me-1"></i>peso@tagudin.gov.ph</li>
                        <li><i class="bi bi-telephone me-1"></i>(077) 674-1234</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copy">
            <div class="container py-3">
                <p class="text-center footer-muted small mb-0">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Municipal PESO - Tagudin, Ilocos Sur. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
