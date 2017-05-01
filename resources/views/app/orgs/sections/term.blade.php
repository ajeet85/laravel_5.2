<div class="editor-area">
    <div class="organisation-section import">
        <div class="overview">
            <p class="title">Import Term Dates</p>
            <p class="description">
                Import your organisations's term dates to help you schedule your provisions.
                <strong>This will remove all your existing term dates.</strong>
            </p>
        </div>

        <form action="/app/orgs/{{$current_org->slug}}/terms/import/default" method="post">
            @include('components.button', ['label' => 'Import Default Term Dates', 'type'=>'submit', 'class' => 'button'])
        </form>
    </div>
</div>
