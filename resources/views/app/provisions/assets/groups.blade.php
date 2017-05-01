<ul>
    <li>
        <span class="provision-resources-title">Vulnerable Groups</span>
        <ul>
            @foreach ($available_groups as $group)
                <?php $disabled = false; ?>
                @if(isset($allocated_groups) && count($allocated_groups) > 0)
                     @foreach( $allocated_groups as $allocated_group)
                        @if( $group->id == $allocated_group->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
                @include('components.checkbox',
                    ['label'=>$group->name,
                    'name'=>'allocated_groups[]',
                    'id'=>'groups_'.$group->id,
                    'value'=>$group->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''
                    ])
            </li>
            @endforeach
        </ul>
    </li>
</ul>
