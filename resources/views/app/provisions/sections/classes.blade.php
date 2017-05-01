<ul>
	@foreach($allocated_classes as $class)
	<li>
		@include('components.checkbox',
            ['label'=>$class->class_name,
            'name'=>'allocated_classes[]',
            'id'=>'classes_'.$class->id,
            'value'=>$class->id,
            'checked'=>'checked'])
    </li>
	@endforeach
</ul>
