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

{{-- Define additional classes  --}}
@section('content-area-class', 'has-toolbar organisation')
@section('content-area')
<form action="/app/settings/billing/invoice/{{$invoice->invoice_number}}/print" method="post">
    <div class="editor-area">
        @include('app.billing.invoice-template')
    </div>
    <div class="tool-bar-area">
        @include('components.button', ['label' => 'Print this invoice', 'type'=>'submit', 'class' => 'button'])
    </div>
</form>
@endsection
