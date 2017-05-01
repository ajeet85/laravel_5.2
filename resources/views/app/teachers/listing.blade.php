
<table class="listing teacher">
    <thead>
        <tr>
            <th>Name</th>
            <th>Provider</th>
            <th>Cost per minute</i></th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($staff_details as $staff_detail)
    <tr class="listing-row">
        <td>
            <a href="/app/orgs/{{$current_org->slug}}/teachers/{{$staff_detail->pt_id}}">
                {{$staff_detail->first_name}} {{$staff_detail->last_name}}
            </a>
        </td>
        <td>
            @if( $staff_detail->provider == 'yes')
                <i class="icon fa fa-check"></i>
            @endif
        </td>
        <td class="@if( $staff_detail->provider == 'yes')is-provider @endif">
            <p class="cost"><span>£{{$staff_detail->cost}}</span></p>
        </td>
        <td class="action">
            <form action="/app/orgs/{{$current_org->slug}}/teachers/{{$staff_detail->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input',
                        ['name'=>'pt_id',
                        'id'=>'pt_id',
                        'value'=>$staff_detail->pt_id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$staff_details->links()}}</td></tr>
    </tbody>
</table>
