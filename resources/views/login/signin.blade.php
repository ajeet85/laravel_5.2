@extends('layouts.access')
@section('title', 'Sign In')
@section('body-class', 'login-page')

@section('content-area')
<form action="/login" method="post" class="auth login">

    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    @include('components.email-input', ['label'=>'Email', 'value'=>''])
    @include('components.password-input', ['label'=>'Password','value'=>''])

    <div class="login-button">
        @include('components.button', ['label' => 'Sign in', 'type'=>'submit', 'class' => 'button'])
    </div>

    @if(isset($error))
    <div class="errors">
        {{ $error }}
    </div>
    @endif

    <div class="register">
        <p>Don't have an account?</p>
        <a href="/signup">Sign up for one</a>.
    </div>

</form>
@endsection
