<div class="organisation-switcher">
    @if(count($orgs_as_options) > 1)
    <form action="/app/{{$org_account->slug}}/orgs/switch" method="post">
        @include('components.hidden-input',
                ['name'=>'current_path',
                'id'=>'current_path',
                'value'=>$current_path])

        @include('components.dropdown-list',
                ['options'=>$orgs_as_options,
                'name'=>'org_id',
                'id'=>'org_id',
                'selected'=>$current_org_id,
                'auto_submit'=>1])
        @include('components.button', ['label' => 'Switch', 'type'=>'submit', 'class' => 'button'])
    </form>
    @endif
</div>
