@extends('layouts.app')
@section('title', 'Teachers')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new staff', 'href'=>"/app/orgs/$current_org->slug/teacher/new", 'class' => 'button'])
@endsection

@section('content-area')
	  @include('app.teachers.listing')
@endsection
