<div class="checkbox-input">
    @if( isset($is_checked) )
        <input type="checkbox" value="{{$value}}" name="{{$name}}" id="{{$id}}" @if($is_checked == $value)checked @endif {{$disabled or ''}} />
    @else
        <input type="checkbox" value="{{$value}}" name="{{$name}}" id="{{$id}}" {{$checked or ''}} {{$disabled or ''}} />
    @endif
    @if( isset($label) )<label for="{{$id}}">{{$label}}</label>@endif
    @if(isset($validate))
    	<div class="error-message">
    		{{ $validate }}
    	</div>
    @endif
</div>

@if( isset($children) )
    @if(count($children) > 0)
    <ul>
        @foreach( $children as $child )
            <?php $disabled = false; ?>
            @if( isset($data) && count($data) > 0 )
                    @foreach( $data as $val)

                    @endforeach
            @endif
            <li>
            @include('components.checkbox',
                    ['name'=>$name,
                    'id'=>$child->value,
                    'label'=>$child->name,
                    'value'=>$child->value,
                    'children'=>$child->children,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
    </ul>
    @endif
@endif
