@props([
    'icon' => 'bi-inbox',
    'title' => 'Nothing here yet',
    'text' => null,
    'actionUrl' => null,
    'actionLabel' => null,
    'actionIcon' => 'bi-plus-lg',
])

<div class="empty-state">
    <div class="empty-state-icon">
        <i class="bi {{ $icon }}" aria-hidden="true"></i>
    </div>
    <h6 class="empty-state-title">{{ $title }}</h6>
    @if($text)
        <p class="empty-state-text">{{ $text }}</p>
    @endif
    @if($actionUrl)
        <a href="{{ $actionUrl }}" class="btn btn-primary btn-sm">
            <i class="bi {{ $actionIcon }} me-1" aria-hidden="true"></i> {{ $actionLabel }}
        </a>
    @endif
</div>
