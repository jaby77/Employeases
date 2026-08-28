@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-app mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-house-door me-1" aria-hidden="true"></i>Home
            </a>
        </li>
        @foreach($items as $item)
            @if(isset($item['url']) && $item['url'])
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
