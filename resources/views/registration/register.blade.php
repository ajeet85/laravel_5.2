@extends('layouts.access')
@section('title', 'Sign up for Provision Tracker')
@section('body-class', 'register-page')

@section('content-area')
<div class="auth registration">

    <div class="logo">
        <img src="/img/product-logos/logo-pink.png" alt="null" />
    </div>

    <form action="/signup" method="post">
        @include('components.hidden-input', ['name'=>'account_name','id'=>'account_name', 'value'=>$account_name])

        <div class="input-group split2">
            @include('components.text-input',
                    ['label'=>'First name',
                    'type'=>'text',
                    'name'=>'first_name',
                    'id'=>'first_name',
                    'value'=>old('first_name'),
                    'validate' => $errors->first('first_name')])

            @include('components.text-input',
                    ['label'=>'Last name',
                    'type'=>'text',
                    'name'=>'last_name',
                    'id'=>'last_name',
                    'value'=>old('last_name'),
                    'validate' => $errors->first('last_name')])
        </div>

        <div class="input-group">
            @if(isset($package))
                @include('components.dropdown-list',
                        ['options'=>$packages,
                        'label'=>'Your Provision Tracker Package',
                        'name'=>'package',
                        'id'=>'package',
                        'selected'=>$package ])
            @else
                @include('components.dropdown-list',
                        ['options'=>$packages,
                        'label'=>'Your Provision Tracker Package',
                        'name'=>'package',
                        'id'=>'package' ])
            @endif
        </div>

        @if(isset($roles))
            @if(count($roles) > 0)
            <div class="input-group">
                @include('components.dropdown-list',
                        ['options'=>$roles,
                        'label'=>'Your role',
                        'name'=>'role',
                        'id'=>'role'])
            </div>
            @endif
        @endif

        <div class="input-group split2">
            @include('components.email-input',
                    ['label'=>'Email',
                    'description'=>'',
                    'value'=>old('email'),
                    'validate' => $errors->first('email')])
            @include('components.password-input', ['label'=>'Password','value'=>'', 'validate' => $errors->first('password')])
        </div>

        <div class="input-group">
            @include('components.checkbox',
                    ['label'=>'Terms and Conditions',
                    'name'=>'tacs',
                    'id'=>'tacs',
                    'value'=>1,
                    'validate' => $errors->first('tacs')])
        </div>

        <div class="package-overview">
            <p class="description">
                All Provision Tracker accounts start with a free trial.<br />
                Explore how Provision Tracker works and how it can help you.<br />
                When you're ready <a href="">choose a package</a> that best suits your organisations needs.
            </p>

            <div class="register-button">
                @include('components.button', ['label' => 'Sign up', 'type'=>'submit', 'class' => 'button'])
            </div>
        </div>



        <div class="errors">
            {{ isset( $error ) ? $error : '' }}
        </div>
    </form>
</div>
@endsection
