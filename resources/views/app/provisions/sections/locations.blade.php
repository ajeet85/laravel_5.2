<ul>
	@foreach($allocated_locations as $location)
	<li>
		@include('components.checkbox',
            ['label'=>$location->name,
            'name'=>'allocated_locations[]',
            'id'=>'allocated_locations_'.$location->id,
            'value'=>$location->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
