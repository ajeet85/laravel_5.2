
<table class="listing resources">
    <thead>
        <tr>
            <th>Name</th>
            <th>Cost</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($resource_details as $resource_detail)
    <tr>
        <td>
            <a href="/app/manage/{{$current_org->slug}}/external-providers/{{$resource_detail->pt_id}}">
                {{$resource_detail->name}}
            </a>
        </td>
        <td>
            <p class="cost"><span>£{{$resource_detail->cost}}</span></p>
        </td>
        <td class="action">
            <form action="/app/manage/{{$current_org->slug}}/external-providers/{{$resource_detail->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input', ['name'=>'pt_id', 'id'=>'pt_id', 'value'=>$resource_detail->pt_id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$resource_details->links()}}</td></tr>
    </tbody>
</table>
