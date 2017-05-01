<ul class="student-class-list">
    @foreach ($students as $student)
        <li>
            @if( $student->in_class )
                @include('components.checkbox',
                        ['label'=>"$student->first_name $student->last_name",
                        'value'=>$student->id,
                        'name'=>"students[$student->id]",
                        'id'=>"students[$student->id]",
                        'checked'=>'checked'])
            @else
                @include('components.checkbox',
                        ['label'=>"$student->first_name $student->last_name",
                        'value'=>$student->id,
                        'name'=>"students[$student->id]",
                        'id'=>"students[$student->id]"])
            @endif
        </li>
    @endforeach
</ul>
