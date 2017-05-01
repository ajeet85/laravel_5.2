
<table class="listing resources">
    <thead>
        <tr>
            <th>Name</th>
            <th>Resource Type</th>
            <th colspan="2">Cost</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($resource_details as $resource_detail)
    <tr>
        <td>
            <a href="/app/orgs/{{$current_org->slug}}/resources/{{$resource_detail->pt_id}}">
                {{$resource_detail->name}}
            </a>
        </td>
        <td>
            {{$resource_detail->resource_type}}
        </td>
        <td>

            <p class="cost">Cost: <span>£{{$resource_detail->cost}}</span></p>
        </td>
        <td class="action">
            <form action="/app/orgs/{{$current_org->slug}}/resources/{{$resource_detail->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button'])
                @include('components.hidden-input',
                        ['name'=>'pt_id',
                        'id'=>'pt_id',
                        'value'=>$resource_detail->pt_id])
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
<table>
{{$resource_details->links()}}
