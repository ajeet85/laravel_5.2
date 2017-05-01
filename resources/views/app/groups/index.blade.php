@extends('layouts.app')
@section('title', 'Groups')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new vulnerable group', 'href'=>"/app/orgs/$current_org->slug/vulnerbale-groups/new", 'class' => 'button'])
     @include('components.link', ['text' => 'Import Vulnerable Groups', 'href'=>"/app/orgs/$current_org->slug/vulnerbale-group/import", 'class' => 'button'])
@endsection

@section('content-area')
	@include('app.groups.listing')
@endsection
