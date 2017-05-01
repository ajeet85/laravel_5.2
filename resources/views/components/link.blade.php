<a href="{{ $href or ''}}" class="{{ $class or ''}}">
     @if( isset($icon))<span class="icon"><i class="fa {{$icon}}" aria-hidden="true"></i></span>@endif
    {{ $text or ''}}
</a>
