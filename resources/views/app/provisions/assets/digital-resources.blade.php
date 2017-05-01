<ul>
    <li>
        <span class="provision-resources-title">Digital Resources</span>
        <ul>
        @foreach( $available_digital_resources as $resource )
            <?php $disabled = false; ?>
              @if(isset($allocated_digital_resources) && count($allocated_digital_resources) > 0)
                    @foreach( $allocated_digital_resources as $allocated_digital_resource)
                        @if( $resource->id == $allocated_digital_resource->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
            @include('components.checkbox',
                    ['label'=>$resource->name,
                    'name'=>'allocated_digital_resources[]',
                    'id'=>'allocated_digital_resources_'.$resource->id,
                    'value'=>$resource->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
        </ul>
    </li>
</ul>
