<ul>
    <li>
        <span class="provision-resources-title">Areas of Need</span>
        <ul>
            @foreach( $available_needs as $need )
                <?php $disabled = false; ?>
                @if(isset($allocated_needs) && count($allocated_needs) > 0)
                    @foreach( $allocated_needs as $allocated_need)
                        @if( $need->value == $allocated_need->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
                <li>

                @include('components.checkbox',
                        ['name'=>'allocated_needs[]',
                        'id'=>$need->value,
                        'label'=>$need->name,
                        'value'=>$need->value,
                        'children'=>$need->children,
                        'data'=>$need,
                        'disabled'=>($disabled) ? 'disabled=disabled':''])
                </li>
            @endforeach
        </ul>
    </li>
</ul>
