<div class="text-input">
    @if(isset($label))<label>{{$label}}</label>@endif
    @if(isset($description))<p class="description">{{ $description }}</p>@endif
    <input type="{{$type}}" name="{{$name}}" id="{{$id}}" value="{{ isset($value) ? $value : '' }}" />
    @if(isset($validate))
    	<div class="error-message">
    		{{ $validate }}
    	</div>
    @endif
</div>
