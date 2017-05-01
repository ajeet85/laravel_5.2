
<table class="listing">
    @foreach ($users as $user)
        <tr>
            <td>
                <a href="/app/settings/users/{{$user->slug}}/permissions">
                    {{$user->first_name}} {{$user->last_name}}
                </a>
            </td>
        </tr>
    @endforeach
</table>
