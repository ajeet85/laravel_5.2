
        <ul>
        @foreach( $allocated_students as $student )
            <li>
            @include('components.checkbox',
                    ['label'=>$student->first_name.' '.$student->last_name,
                    'name'=>'allocated_students[]',
                    'id'=>'allocated_students_'.$student->id,
                    'value'=>$student->id,
                    'checked'=>'checked'])
            </li>
        @endforeach
        </ul>
