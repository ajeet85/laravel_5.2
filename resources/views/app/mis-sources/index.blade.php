@extends('layouts.app')
@section('title', 'MIS Sources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')

@endsection

@section('content-area')
    <div class="editor-area">
        @include('app.mis-sources.listing')
    </div>
@endsection
