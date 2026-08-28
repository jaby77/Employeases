{{-- Standalone branded error page (no framework branding). Inline CSS so it
     still renders even if the asset pipeline fails. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code ?? 'Error' }} — {{ config('app.name', 'EmployEase') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .error-header {
            background: #fff;
            border-bottom: 1px solid rgba(10, 37, 64, .07);
            padding: .875rem 0;
        }
        .error-header .container {
            max-width: 1080px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }
        .error-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .error-brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0A2540, #1E3A5F);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            box-shadow: 0 4px 10px rgba(10, 37, 64, .2);
        }
        .error-brand-name {
            color: #0A2540;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: .4px;
            line-height: 1;
        }
        .error-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.25rem;
        }
        .error-card {
            background: #fff;
            border: 1px solid rgba(10, 37, 64, .06);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 1px 2px rgba(10, 37, 64, .04), 0 12px 32px rgba(10, 37, 64, .08), 0 32px 80px rgba(10, 37, 64, .06);
        }
        .error-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 1.25rem;
            border-radius: 22px;
            background: rgba(227, 160, 8, .12);
            border: 1px solid rgba(201, 151, 0, .25);
            color: #C99700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .error-code {
            font-size: 3rem;
            font-weight: 800;
            color: #0A2540;
            letter-spacing: -.02em;
            line-height: 1;
            margin-bottom: .5rem;
        }
        .error-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0A2540;
            margin-bottom: .6rem;
        }
        .error-message {
            color: #64748b;
            font-size: .925rem;
            line-height: 1.7;
            margin-bottom: 1.75rem;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: linear-gradient(135deg, #E3A008, #C99700);
            color: #0A2540;
            border: none;
            border-radius: 12px;
            padding: .8rem 1.5rem;
            font-size: .95rem;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            transition: all .25s ease;
            box-shadow: 0 4px 14px rgba(227, 160, 8, .28);
        }
        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(227, 160, 8, .38);
        }
        .error-footer {
            text-align: center;
            padding: 1.5rem;
            color: #94a3b8;
            font-size: .8rem;
        }
    </style>
</head>
<body>
    <header class="error-header">
        <div class="container">
            <a class="error-brand" href="{{ url('/') }}">
                <span class="error-brand-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l.776.493a1.5 1.5 0 0 0 1.448 0L3 5.63v.337A1.5 1.5 0 0 0 1.5 7.5V9a1.5 1.5 0 0 0 1.5 1.5H2.5v2h1V10h9v2.5h1V10H15a1.5 1.5 0 0 0 1.5-1.5V7.5A1.5 1.5 0 0 0 15 6V5.63l.776.247a1.5 1.5 0 0 0 1.448 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3Zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5Z"/></svg>
                </span>
                <span class="error-brand-name">{{ config('app.name', 'EmployEase') }}</span>
            </a>
        </div>
    </header>

    @php
        // Per-page error icons — inline SVG so error pages need zero icon CDNs.
        $errorIcons = [
            'bi-compass' => '<path d="M8 16.016a7.5 7.5 0 0 0 1.962-14.74A1 1 0 0 0 9 0H7a1 1 0 0 0-.962 1.276A7.5 7.5 0 0 0 8 16.016m6.5-7.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0"/>',
            'bi-shield-lock' => '<path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>',
            'bi-hourglass-split' => '<path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>',
            'bi-speedometer2' => '<path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z"/>',
            'bi-exclamation-triangle' => '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>',
            'bi-tools' => '<path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>',
        ];
        $errorIcon = $errorIcons[$icon ?? ''] ?? $errorIcons['bi-exclamation-triangle'];
    @endphp

    <div class="error-body">
        <div class="error-card">
            <div class="error-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">{!! $errorIcon !!}</svg>
            </div>
            <div class="error-code">{{ $code }}</div>
            <h1 class="error-title">{{ $title }}</h1>
            <p class="error-message">{{ $message }}</p>
            <a href="{{ url('/') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/></svg>
                Back to Home
            </a>
        </div>
    </div>

    <div class="error-footer">
        &copy; {{ date('Y') }} {{ config('app.name', 'EmployEase') }} &middot; Municipal PESO &mdash; Tagudin, Ilocos Sur
    </div>
</body>
</html>
