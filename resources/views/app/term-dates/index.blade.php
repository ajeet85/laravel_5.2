@extends('layouts.app')
@section('title', 'Term Dates')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new Term', 'href'=>"/app/orgs/$current_org->slug/terms/new", 'class' => 'button has-icon', 'icon'=>'fa-plus-circle'])
     @include('components.link', ['text' => 'Import Terms', 'href'=>"/app/orgs/$current_org->slug/term/import", 'class' => 'button'])
@endsection

@section('content-area')
    @include('app.term-dates.listing')
@endsection
