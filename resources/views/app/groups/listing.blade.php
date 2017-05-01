<table class="listing">
    <thead>
        <tr>
            <th>Vulnerable Group Name</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($groups_detail as $group_detail)

    <tr>
        <td><a href="/app/orgs/{{$current_org->slug}}/vulnerbale-groups/{{$group_detail->pt_id}}">{{$group_detail->name}}</a></td>
        <td class="action">
            @if( $group_detail->organisation_id )
                <form action="/app/orgs/{{$current_org->slug}}/vulnerbale-groups/{{$group_detail->pt_id}}" method="POST">
                    {{ method_field("DELETE") }}
                    @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                    @include('components.hidden-input',
                            ['name'=>'pt_id',
                            'id'=>'pt_id',
                            'value'=>$group_detail->pt_id])
                </form>
            @endif
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$groups_detail->links()}}</td></tr>
    </tbody>
</table>
