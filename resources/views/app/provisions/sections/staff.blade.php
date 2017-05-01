<ul>
@foreach( $allocated_staff as $teacher )
    <li>
    @include('components.checkbox',
            ['label'=>$teacher->first_name.' '.$teacher->last_name,
            'name'=>'allocated_staff[]',
            'id'=>'allocated_staff_'.$teacher->id,
            'value'=>$teacher->id,
            'checked'=>'checked'])
    </li>
@endforeach
</ul>
