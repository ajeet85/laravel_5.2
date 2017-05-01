@extends('layouts.access')
@section('title', 'Thanks for signing up')
@section('body-class', 'register-thanks-page')

@section('content-area')
<div class="auth registration-thanks">
    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    <div class="registration-thanks-message">
        <p>Thanks for signing up to Provision Tracker.<br />
           Look out for an email to confirm the account.</p>
        <p>When you have confirmed your account, you can use the link below to sign in.</p>
    </div>

    <div class="registration-thanks-button">
        @include('components.link', ['text' => 'Sign in', 'href'=>'/login'])
    </div>
</div>
@endsection
