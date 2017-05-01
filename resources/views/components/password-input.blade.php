<div class="text-input password">
    <label>{{$label}}</label>
    @if(isset($description))<p class="description">{{ $description }}</p>@endif
    <input type="password" name="password" id="password" value="{{ isset($value) ? $value : '' }}" />
    @if(isset($validate))
    	<div class="error-message">
    		{{ $validate }}
    	</div>
    @endif
</div>
