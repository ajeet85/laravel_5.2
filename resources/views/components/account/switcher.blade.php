<div class="account-switcher">
    @if (count($accounts) > 1)
    <label>Switch accounts:</label>
    <form action="/login/select-account" method="post">
        @include('components.dropdown-list',
                ['options'=>$accs_as_options,
                'name'=>'account',
                'id'=>'account',
                'selected'=>$current_account_id,
                'auto_submit'=>1])

        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
    @endif
</div>
