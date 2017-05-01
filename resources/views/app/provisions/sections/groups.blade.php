<ul>
    @foreach( $allocated_groups as $group )
        <li>
        @include('components.checkbox',
                ['label'=>$group->name,
                'name'=>'allocated_groups[]',
                'id'=>'allocated_groups_'.$group->id,
                'value'=>$group->id,
                'checked'=>'checked'])
        </li>
    @endforeach
</ul>
