<div class="editor-area">
    <div class="organisation-section import">
        <div class="overview">
            <p class="title">Import Assesments</p>
            <p class="description">
                Import your organisations's assesments to help you schedule your provisions.
                <strong>This will remove all your existing assesments.</strong>
            </p>
        </div>

        <form action="/app/orgs/{{$current_org->slug}}/assessment-types/import/default" method="post">
            @include('components.button', ['label' => 'Import Assesments', 'type'=>'submit', 'class' => 'button'])
        </form>
    </div>
</div>
