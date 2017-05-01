@extends('layouts.app')
@section('title', 'Assessment Types')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
	@include('components.link', ['text' => 'Import Assessment Types', 'href'=>"/app/orgs/$current_org->slug/assessment-type/import", 'class' => 'button'])
@endsection

@section('content-area')
    @include('app.assessment-types.listing')
@endsection
