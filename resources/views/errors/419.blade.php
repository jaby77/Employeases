@include('partials.error-page', [
    'code' => 419,
    'title' => 'Session Expired',
    'message' => 'Your session has expired. Please sign in again to continue.',
    'icon' => 'bi-hourglass-split',
])
