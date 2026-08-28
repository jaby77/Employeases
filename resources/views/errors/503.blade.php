@include('partials.error-page', [
    'code' => 503,
    'title' => 'Service Unavailable',
    'message' => 'The system is temporarily down for maintenance. Please check back shortly.',
    'icon' => 'bi-tools',
])
