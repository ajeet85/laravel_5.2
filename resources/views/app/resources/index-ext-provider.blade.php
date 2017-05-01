@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add External Provider', 'href'=>"/app/manage/$current_org->slug/external-providers/new", 'class' => 'button'])

@endsection

@section('content-area')
	@include('app.resources.listing-ext-provider')
@endsection
