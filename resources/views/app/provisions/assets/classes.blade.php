<ul>
    <li>
        <span class="provision-resources-title">Classes and Groups</span>
        <ul>
            @foreach( $available_classes as $class )
                 <?php $disabled = false; ?>
                @if(isset($allocated_classes) && count($allocated_classes) > 0)
                    @foreach( $allocated_classes as $allocated_class)
                        @if( $class->id == $allocated_class->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
                <li>
                @include('components.checkbox',
                    ['label'=>$class->class_name,
                    'name'=>'allocated_classes[]',
                    'id'=>'classes_'.$class->id,
                    'value'=>$class->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
                </li>
            @endforeach
        </ul>
    </li>
</ul>
