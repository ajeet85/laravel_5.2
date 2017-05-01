@extends('layouts.app')
@section('title', 'Organisations')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Find your School
@endsection

@section('content-area-class', 'has-toolbar')
@section('content-area')
<form action="/app/orgs/find/" method="get">
    <div class="editor-area">
            @include('components.text-input',
                    ['label'=>'School Name',
                    'description' => 'A schools name is not always unique, so please enter the school name if known.',
                    'type'=>'text',
                    'name'=>'name',
                    'id'=>'name',
                    'value'=>old('name'),
                    'validate'=>$errors->first('name')])

            @include('components.text-input',
                    ['label'=>'DfE Number',
                    'description' => 'A DfE number is a unique number that identifes a school. Enter it here to increase the chances of finding a match.',
                    'type'=>'text',
                    'name'=>'dfe_number',
                    'id'=>'dfe_number',
                    'validate'=>$errors->first('dfe_number')])

            @include('components.text-input',
                    ['label'=>'Postcode',
                    'description' => 'Including your postcode as part of the search will help us narrow down the search results.',
                    'type'=>'text',
                    'name'=>'postcode',
                    'id'=>'postcode',
                    'validate'=>$errors->first('postcode')])

            @include('components.hidden-input', ['name'=>'account_id', 'id'=>'account_id', 'value'=>$current_account_id])
            @include('components.hidden-input', ['name'=>'org_type', 'id'=>'org_type', 'value'=>1])


    </div>
    <div class="tool-bar-area">
        @include('components.button', ['label' => 'Find your school', 'type'=>'submit', 'class' => 'button'])
    </div>
</form>

<div class="editor-area">
    <div class="organisation-section">
        @include('app.orgs.listing-imported')
    </div>
</div>

@endsection
