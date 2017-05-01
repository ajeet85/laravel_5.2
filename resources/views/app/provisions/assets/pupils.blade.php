<ul>
    <li>
        <span class="provision-resources-title">Pupils and Students</span>
        <ul>
        @foreach( $available_students as $student )
            <?php $disabled = false; ?>
              @if(isset($allocated_students) && count($allocated_students) > 0)
                    @foreach( $allocated_students as $allocated_student)
                        @if( $student->id == $allocated_student->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
            @include('components.checkbox',
                    ['label'=>$student->first_name.' '.$student->last_name,
                    'name'=>'allocated_students[]',
                    'id'=>'students_'.$student->id,
                    'value'=>$student->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
        </ul>
    </li>
</ul>
