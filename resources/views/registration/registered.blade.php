@extends('layouts.access')
@section('title', 'Thanks for confirming your account')
@section('body-class', 'register-thanks-page')

@section('content-area')
<div class="auth registration-thanks">
    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    <div class="registration-thanks-message">
        <p>Hey, looks like you've already registered.<br />
           You can use the link below to sign in.</p>
    </div>

    <div class="registration-thanks-button">
        @include('components.link', ['text' => 'Sign in', 'href'=>'/login'])
    </div>
</div>
@endsection
