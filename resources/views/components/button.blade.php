<button type="{{ $type }}" class="{{ $class }} @if( isset($icon)) has-icon @endif">
     @if( isset($icon))<span class="icon"><i class="fa {{$icon}}" aria-hidden="true"></i></span>@endif
    <span class="label">{{ $label }}</span>
</button>
