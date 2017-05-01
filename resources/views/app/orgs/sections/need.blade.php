<div class="editor-area">
    <div class="organisation-section import">
        <div class="overview">
            <p class="title">Import Area Of Need</p>
            <p class="description">
                Import your organisations's Needs to help you schedule your provisions.
                <strong>This will remove all your existing Needs.</strong>
            </p>
        </div>

        <form action="/app/orgs/{{$current_org->slug}}/needs/import/default" method="post">
            @include('components.button', ['label' => 'Import Default Areas Of Need', 'type'=>'submit', 'class' => 'button'])
        </form>
    </div>
</div>
