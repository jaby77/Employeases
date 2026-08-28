@include('partials.error-page', [
    'code' => 500,
    'title' => 'Something Went Wrong',
    'message' => 'An unexpected error occurred on our end. Please try again in a moment.',
    'icon' => 'bi-exclamation-triangle',
])
