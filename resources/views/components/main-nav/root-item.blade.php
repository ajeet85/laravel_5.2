<li>
    <a class="nav-root-item @if($current_root_item == $slug)open @endif" href="{{$link}}">
        <span class="icon"><i class="fa {{$icon}}" aria-hidden="true"></i></span>
        {{$label}}
    </a>
    @if( isset($submenu) )
        @include($submenu)
    @endif
</li>
