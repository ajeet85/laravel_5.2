@inject('utils', 'App\Providers\ProvisionTracker\UtilsServiceInterface')
<table class="listing terms">
    <thead>
        <tr>
            <th>Name</th>
            <th>Start date</th>
            <th>End date</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($terms as $term)
        <tr class="listing-row">
            <td>
                <a href="/app/orgs/{{$current_org->slug}}/terms/{{$term->pt_id}}">
                    {{$term->name}}
                </a>
            </td>
            <td>
                {{$utils->formatDate($term->start_date)}}
            </td>
            <td>
                {{$utils->formatDate($term->end_date)}}
            </td>
            <td class="action">
                @if( $term->organisation_id )
                <form action="/app/orgs/{{$current_org->slug}}/terms/{{$term->pt_id}}" method="post">
                    {{ method_field("DELETE") }}
                    @include('components.hidden-input', ['name'=>'id','id'=>'id','value'=>$term->id])
                    @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                </form>
                @endif
            </td>
        </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$terms->links()}}</td></tr>
    </tbody>
</table>
