<table class="listing">
    <thead>
        <tr>
            <th>Name</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($user_organisations as $organisation)
    <tr class="listing-row">
        <td><a href="/app/orgs/{{$organisation->slug}}">{{$organisation->name}}</a></td>
        <td class="action">
            <form action="/app/orgs/{{$organisation->slug}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input',
                        ['name'=>'id',
                        'id'=>'id',
                        'value'=>$organisation->id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$user_organisations->links()}}</td></tr>
</tbody>
</table>
