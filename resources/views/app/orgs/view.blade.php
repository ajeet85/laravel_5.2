@extends('layouts.app')
@section('title', 'Organisations')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    School details
@endsection

{{-- Define additional classes  --}}
@section('content-area-class', 'has-toolbar organisation')

@section('content-area')
<form action="" method="post">
    <div class="editor-area">
        <h1>School Name</h1>
        <p>{{$organisation->name}}</p>

        <h1>DfE Number</h1>
        <p>{{$organisation->organisation_id}}</p>

        <h1>School postcode</h1>
        <p>{{$organisation->address}}</p>
    </div>
    <div class="tool-bar-area">
        @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
    </div>
</form>

@include('app.orgs.sections.term')
@include('app.orgs.sections.group')
@include('app.orgs.sections.need')
@include('app.orgs.sections.assesments')

@endsection
