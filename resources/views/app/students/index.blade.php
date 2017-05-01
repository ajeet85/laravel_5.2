@extends('layouts.app')
@section('title', 'Pupils')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')

@include('components.link', ['text' => 'Add Pupils', 'href'=>"/app/orgs/$current_org->slug/pupil/new", 'class' => 'button'])
@endsection

@section('content-area')
    @include('app.students.listing')
@endsection
