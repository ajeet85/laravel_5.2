@extends('layouts.printable-document')
@section('title', 'Billing')

@section('content-area')
    <div class="editor-area">
        @include('app.billing.invoice-template')
    </div>
@endsection
