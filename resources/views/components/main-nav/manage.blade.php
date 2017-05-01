<div class="child-menu">

    <ul>
        <li><a class="nav-child-item @if($current_child_item == 'time-slots')open @endif"
            href="/app/manage/{{$current_org->slug}}/time-slots">Time Slots</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'provisions')open @endif"
            href="/app/manage/{{$current_org->slug}}/provisions">Provisions</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'digital-resources')open @endif"
            href="/app/manage/{{$current_org->slug}}/digital-resources">Digital Resources</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'physical-resources')open @endif"
            href="/app/manage/{{$current_org->slug}}/physical-resources">Physical Resources</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'locations')open @endif"
            href="/app/manage/{{$current_org->slug}}/locations">Rooms and Locations</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'external-providers')open @endif"
            href="/app/manage/{{$current_org->slug}}/external-providers">External Providers</a></li>

    </ul>
</div>
