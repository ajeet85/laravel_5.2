<ul>
	@foreach($allocated_digital_resources as $resource)
	<li>
		@include('components.checkbox',
            ['label'=>$resource->name,
            'name'=>'allocated_digital_resources[]',
            'id'=>'allocated_digital_resources'.$resource->id,
            'value'=>$resource->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
