<ul>
    <li>
        <span class="provision-resources-title">Time Slots</span>
        <ul>
            @foreach( $available_times as $time )
                 <?php $disabled = false; ?>
                @if(isset($allocated_times) && count($allocated_times) > 0)
                    @foreach( $allocated_times as $allocated_time)
                        @if( $time->id == $allocated_time->id )
                            <?php $disabled = true; break; ?>
                        @endif
                    @endforeach
                @endif
                <li>
                @include('components.checkbox',
                    ['label'=>$time->name,
                    'name'=>'allocated_times[]',
                    'id'=>'time_'.$time->id,
                    'value'=>$time->id,
                    'disabled'=>($disabled) ? 'disabled=disabled':''])
                </li>
            @endforeach
        </ul>
    </li>
</ul>
