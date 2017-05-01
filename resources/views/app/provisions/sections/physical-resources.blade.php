<ul>
	@foreach($allocated_physical_resources as $resource)
	<li>
		@include('components.checkbox',
            ['label'=>$resource->name,
            'name'=>'allocated_physical_resources[]',
            'id'=>'allocated_physical_resources'.$resource->id,
            'value'=>$resource->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
