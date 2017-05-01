<ul>
    <li>
        <span class="provision-resources-title">Locations</span>
        <ul>
        @foreach( $available_locations as $resource )
            <?php $disabled = false; ?>
              @if(isset($allocated_locations) && count($allocated_locations) > 0)
                    @foreach( $allocated_locations as $allocated_location)
                        @if( $resource->id == $allocated_location->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
            @include('components.checkbox',
                    ['label'=>$resource->name,
                    'name'=>'allocated_locations[]',
                    'id'=>'allocated_locations_'.$resource->id,
                    'value'=>$resource->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
        </ul>
    </li>
</ul>
