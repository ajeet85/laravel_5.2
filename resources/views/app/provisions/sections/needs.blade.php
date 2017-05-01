<ul>
	@foreach($allocated_needs as $need)
	<li>
		@include('components.checkbox',
            ['label'=>$need->name,
            'name'=>'allocated_needs[]',
            'id'=>'allocated_needs_'.$need->id,
            'value'=>$need->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
