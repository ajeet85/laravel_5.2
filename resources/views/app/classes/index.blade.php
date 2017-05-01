@extends('layouts.app')
@section('title', 'Classes')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new class', 'href'=>"/app/orgs/$current_org->slug/classes/new", 'class' => 'button'])

@endsection

@section('content-area')
	 @include('app.classes.listing')
@endsection
