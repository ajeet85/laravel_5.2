Staff
<ul class="student-class-list">
    @foreach ($staff_members as $staff_member)
        <?php $checked = false; ?>
        @foreach ($class_staff as $staff)
            @if($staff_member->value == $staff->staff_id)
                <?php $checked = true; ?>
                
            @endif
        @endforeach
        <li>
            
                @include('components.checkbox',
                        ['label'=>"$staff_member->name",
                        'value'=>$staff_member->value,
                        'name'=>"staff[]",
                        'id'=>"staff.'_'.$staff_member->value",
                        'checked'=>($checked) ? 'checked' : ''])
            
        </li>
    @endforeach
</ul>
