@include('partials.error-page', [
    'code' => 403,
    'title' => 'Access Denied',
    'message' => 'You do not have permission to access this page. If you believe this is a mistake, contact the system administrator.',
    'icon' => 'bi-shield-lock',
])
