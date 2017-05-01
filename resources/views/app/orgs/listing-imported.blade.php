<table class="listing uk-schools">
    <thead>
        <tr>
            <th>DfE number</th>
            <th>Name</th>
            <th>Local Authority</th>
            <th>Postcode</th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($user_organisations as $organisation)
    <tr class="listing-row">
        <td>DfE: {{$organisation->dfe}}</td>
        <td>{{$organisation->name}}</td>
        <td>{{$organisation->local_authority}}</td>
        <td>{{$organisation->postcode}}</td>
        <td class="action">
            @if($organisation->claimed == 'no')
                <form action="/app/orgs/new" method="post">
                    @include('components.hidden-input',['name'=>'account_id','id'=>'account_id','value'=>$current_account_id])
                    @include('components.hidden-input',['name'=>'org_id','id'=>'org_id','value'=>$organisation->dfe])
                    @include('components.hidden-input',['name'=>'org_address','id'=>'org_address','value'=>$organisation->postcode])
                    @include('components.hidden-input',['name'=>'org_name','id'=>'org_name','value'=>$organisation->name])
                    @include('components.hidden-input',['name'=>'org_type','id'=>'org_type','value'=>1])
                    @include('components.button', ['label' => '', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-plus-circle'])
                </form>
            @else
                @if($organisation->claimed_by == $current_user->pt_id)
                    @include('components.button', ['label' => '', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-check'])
                @else
                    @include('components.button', ['label' => '', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-lock'])
                @endif
            @endif

        </td>
        <td class="action">
            @if($organisation->claimed == 'yes')
                @if($organisation->claimed_by != $current_user->pt_id)
                    @include('components.button', ['label' => '', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-link'])
                @endif
            @endif
        </td>
    </tr>
    @endforeach

    </tbody>
</table>
