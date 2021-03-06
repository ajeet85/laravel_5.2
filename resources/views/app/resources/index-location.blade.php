@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add Location', 'href'=>"/app/manage/$current_org->slug/locations/new", 'class' => 'button'])

@endsection

@section('content-area')
	@include('app.resources.listing-location')
@endsection
