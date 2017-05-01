<ul>
    <li>
        <span class="provision-resources-title">External Providers</span>
        <ul>
        @foreach( $available_external_providers as $resource )
            <?php $disabled = false; ?>
              @if(isset($allocated_external_providers) && count($allocated_external_providers) > 0)
                    @foreach( $allocated_external_providers as $allocated_external_provider)
                        @if( $resource->id == $allocated_external_provider->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
            <li>
            @include('components.checkbox',
                    ['label'=>$resource->name,
                    'name'=>'allocated_external_providers[]',
                    'id'=>'allocated_external_providers_'.$resource->id,
                    'value'=>$resource->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
            </li>
        @endforeach
        </ul>
    </li>
</ul>
