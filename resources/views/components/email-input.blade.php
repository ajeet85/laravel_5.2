<div class="text-input email">
    <label>{{$label}}</label>
    @if(isset($description))<p class="description">{{ $description }}</p>@endif
    <input type="email" name="email" id="email" value="{{ isset($value) ? $value : '' }}" />
    <p>{{ isset($description) ? $description : '' }}</p>
    @if(isset($validate))
    	<div class="error-message">
    		{{ $validate }}
    	</div>
    @endif
</div>
