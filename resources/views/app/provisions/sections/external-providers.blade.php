<ul>
	@foreach($allocated_external_providers as $resource)
	<li>
		@include('components.checkbox',
            ['label'=>$resource->name,
            'name'=>'allocated_external_providers[]',
            'id'=>'allocated_external_providers'.$resource->id,
            'value'=>$resource->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
