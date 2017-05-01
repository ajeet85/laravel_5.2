<div class="select">
    @if(isset($label))<span class="label">{{$label}}</span>@endif
    @if(isset($description))<p class="description">{{ $description }}</p>@endif
    <label class="select-wrapper">
        <select name="{{$name}}" id="{{$id}}" @if(isset($auto_submit))auto-submit="true" @endif>
            @foreach ($options as $option)
                <option value="{{$option->value}}"
                    @if( isset($selected) )
                        @if($selected == $option->value) selected
                        @endif
                    @endif>
                    {{$option->name}}
                </option>
                @if( isset($option->children) )
                    @if( count($option->children) > 0)
                        @include('components.dropdown-list-child', ['options'=>$option->children, 'level'=>1])
                    @endif
                @endif
            @endforeach
        </select>
        <i class="icon fa fa-chevron-down"></i>
    </label>
    @if(isset($validate))
    	<div calss="error-message">
    		{{$validate}}
    	</div>
    @endif
</div>
