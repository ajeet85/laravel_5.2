<div class="child-menu">
    <p class="current-organisation">
        <a href="/app/orgs/{{$current_org->slug}}">{{$current_org->name}}</a>
    </p>
    <ul>
        <li><a class="nav-child-item @if($current_child_item == 'mis-sources')open @endif"
            href="/app/orgs/{{$current_org->slug}}/mis-sources">MIS Sources</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'teachers')open @endif"
            href="/app/orgs/{{$current_org->slug}}/teachers">Staff Members</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'pupils')open @endif"
                href="/app/orgs/{{$current_org->slug}}/pupils">Pupils and Students</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'classes')open @endif"
            href="/app/orgs/{{$current_org->slug}}/classes">Classes and Groups</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'terms')open @endif"
            href="/app/orgs/{{$current_org->slug}}/terms">Term Dates</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'assessment-types')open @endif"
                href="/app/orgs/{{$current_org->slug}}/assessment-types">Assessment Types</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'vulnerbale-groups')open @endif"
            href="/app/orgs/{{$current_org->slug}}/vulnerbale-groups">Vulnerable Groups</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'needs')open @endif"
            href="/app/orgs/{{$current_org->slug}}/needs">Areas of need</a></li>
    </ul>
</div>
