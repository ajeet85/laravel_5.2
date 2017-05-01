@extends('layouts.app')
@section('title', 'Users')

@section('title-area')
    Settings / Users
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new user', 'href'=>'/app/settings/users/new', 'class' => 'button'])
@endsection

@section('content-area')
    @include('app.settings.user-listing')
@endsection
