@extends('layouts.app')
@section('title', 'Billing')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Your Invoices
@endsection

@section('action-area')

@endsection

@section('content-area')
    @include('app.billing.listing')
@endsection
