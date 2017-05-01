
@extends('layouts.access')
@section('title', 'Account not found')
@section('body-class', 'register-thanks-page')

@section('content-area')
<div class="auth registration-thanks">
    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    <div class="registration-thanks-message">
        <p>This account does not exist<br />
           Use the link below to register for a new account</p>
    </div>

    <div class="registration-thanks-button">
        @include('components.link', ['text' => 'Sign up for an account', 'href'=>'/signup'])
    </div>
</div>
@endsection
