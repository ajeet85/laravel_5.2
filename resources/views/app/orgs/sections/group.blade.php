<div class="editor-area">
    <div class="organisation-section import">
        <div class="overview">
            <p class="title">Import Vulnerable Groups</p>
            <p class="description">
                Import your organisations's vulnerable groups to help you schedule your provisions.
                <strong>This will remove all your existing vulnerable groups.</strong>
            </p>
        </div>

        <form action="/app/orgs/{{$current_org->slug}}/vulnerbale-groups/import/default" method="post">
            @include('components.button', ['label' => 'Import Default Vulnerable Groups', 'type'=>'submit', 'class' => 'button'])
        </form>
    </div>
</div>
