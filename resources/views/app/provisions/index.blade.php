@extends('layouts.app')
@section('title', 'Provisions')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add Provisions', 'href'=>"/app/manage/$current_org->slug/provisions/new", 'class' => 'button'])
@endsection

@section('content-area')
	 @include('app.provisions.listing')
@endsection
