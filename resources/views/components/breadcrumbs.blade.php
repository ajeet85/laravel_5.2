@if ($breadcrumbs)
    <ul class="breadcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li class="breadcrumb"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif
