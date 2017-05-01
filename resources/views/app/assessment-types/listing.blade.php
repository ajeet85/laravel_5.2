<table class="listing assessment-types">
    <thead>
        <tr>
            <th>Name</th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($assessment_types as $assessment_type)
        <tr class="listing-row">
            <td>
                <a href="/app/orgs/{{$current_org->slug}}/assessment-types/{{$assessment_type->slug}}">
                    {{$assessment_type->name}}
                </a>
            </td>
            <td class="action">
                <form action="/app/orgs/{{$current_org->slug}}/assessment-types/copy" method="post">
                    @include('components.hidden-input', ['name'=>'assessment_type_id','id'=>'assessment_type_id','value'=>$assessment_type->id])
                    @include('components.hidden-input', ['name'=>'mode','id'=>'mode','value'=>'copy'])
                    @include('components.hidden-input', ['name'=>'organisation_id','id'=>'organisation_id', 'value'=>$current_org_id])
                    @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-clone'])
                </form>
            </td>
            <td class="action">
                @if( $assessment_type->organisation_id )
                <form action="/app/orgs/{{$current_org->slug}}/assessment-types/{{$assessment_type->slug}}" method="post">
                    {{ method_field("DELETE") }}
                    @include('components.hidden-input', ['name'=>'assessment_type_id','id'=>'assessment_type_id','value'=>$assessment_type->id])
                    @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                </form>
                @endif
            </td>
        </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$assessment_types->links()}}</td></tr>
    </tbody>
</table>
