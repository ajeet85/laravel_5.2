<ul>
    <li>
        <span class="provision-resources-title">Staff</span>
        <ul>
            @foreach( $available_staff as $teacher )
                 <?php $disabled = false; ?>
                @if(isset($allocated_staff) && count($allocated_staff) > 0)
                    @foreach( $allocated_staff as $allocated_teacher)
                        @if( $teacher->id == $allocated_teacher->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
                <li>
                @include('components.checkbox',
                    ['label'=>$teacher->first_name.' '.$teacher->last_name,
                    'name'=>'allocated_staff[]',
                    'id'=>'staff_'.$teacher->id,
                    'value'=>$teacher->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
                </li>
            @endforeach
        </ul>
    </li>
</ul>
