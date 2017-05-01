@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add Physical Resource', 'href'=>"/app/manage/$current_org->slug/physical-resources/new", 'class' => 'button'])

@endsection

@section('content-area')
	@include('app.resources.listing-physical')
@endsection
