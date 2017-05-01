<ul>
    <li>
        <span class="provision-resources-title">Physical Resources</span>
        <ul>
        @foreach( $available_physical_resources as $resource )
            <?php $disabled = false; ?>
              @if(isset($allocated_physical_resources) && count($allocated_physical_resources) > 0)
                    @foreach( $allocated_physical_resources as $allocated_physical_resource)
                        @if( $resource->id == $allocated_physical_resource->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
            @include('components.checkbox',
                    ['label'=>$resource->name,
                    'name'=>'allocated_physical_resources[]',
                    'id'=>'physical_resources_'.$resource->id,
                    'value'=>$resource->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
        </ul>
    </li>
</ul>
