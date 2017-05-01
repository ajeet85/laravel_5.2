@extends('layouts.access')
@section('title', 'Select your account')
@section('body-class', 'account-selection-page')


@section('content-area')
<div class="auth account-selection">
    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    <div class="account-selection-message">
        <p>You are connected to more than one account.<br />
           Choose the account you want to sign in with.
        </p>
        <form action="/login/select-account" method="post">
            @include('components.dropdown-list',
                    ['options'=>$accs_as_options,
                    'name'=>'account',
                    'id'=>'account',
                    'selected'=>$current_account_id])

            @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
        </form>
    </div>
</div>
@endsection
