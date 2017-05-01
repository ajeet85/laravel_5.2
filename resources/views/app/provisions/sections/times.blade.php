<ul>
    @foreach( $allocated_times as $time )
        <li>
        @include('components.checkbox',
            ['label'=>$time->name,
            'name'=>'allocated_times[]',
            'id'=>'allocated_time_'.$time->id,
            'value'=>$time->id,
            'checked'=>'checked'])
        </li>
    @endforeach
</ul>
