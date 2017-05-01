<div class="child-menu">
    <ul>
        <li><a class="nav-child-item @if($current_child_item == 'profile')open @endif"
            href="/app/settings/profile">Profile</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'notifications')open @endif"
            href="/app/settings/notifications">Notifications</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'users')open @endif"
            href="/app/settings/users">Users</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'permissions')open @endif"
            href="/app/settings/permissions">Permissions</a></li>

        <li><a class="nav-child-item @if($current_child_item == 'billing')open @endif"
            href="/app/settings/billing">Billing</a></li>
    </ul>
</div>
