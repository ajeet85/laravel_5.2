@foreach ($options as $option)
<option value="{{$option->value}}"
    @if( isset($selected) )
        @if($selected == $option->value) selected
        @endif
    @endif>
    @for ($i = 0; $i < $level; $i++)
        -
    @endfor
    {{$option->name}}
</option>
@if( count($option->children) > 0 )
    
    @include('components.dropdown-list-child', ['options'=>$option->children, 'level'=>($level + 1)])
@endif
@endforeach
