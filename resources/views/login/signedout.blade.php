@extends('layouts.access')
@section('title', 'You have signed out')
@section('body-class', 'loggedout-page')

@section('content-area')
    <div class="auth logged-out">
        <div class="logo">
            <img src="/img/product-logos/logo-pink.png" alt="null" />
        </div>

        <div class="logged-out-message">
            <p>Thanks for using Provision Tracker today! You have successfully signed out.</p>
        </div>

        <div class="logged-out-button">
            @include('components.link', ['text' => 'Sign in again', 'href'=>'/login'])
        </div>

    </div>
@endsection
