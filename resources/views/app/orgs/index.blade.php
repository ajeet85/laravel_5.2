@extends('layouts.app')
@section('title', 'Organisations')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    <form action="/app/orgs/" method="get">
    @include('components.text-input',
            ['type'=>'text',
            'name'=>'q',
            'id'=>'search_query'])
    @include('components.button', ['label' => 'Search', 'type'=>'submit', 'class' => 'button'])
    </form>
@endsection

@section('action-area')
    {{-- @include('components.link', ['text' => 'Add new organisation', 'href'=>'/app/orgs/new', 'class' => 'button has-icon', 'icon'=>'fa-plus-circle']) --}}
    <div class="org-type-chooser">
        @if(count($org_types) > 1)
        <label>Add a new: </label>
        <form action="/app/orgs/find/" method="get">
            @include('components.dropdown-list',
                    ['options'=>$org_types,
                    'name'=>'type',
                    'id'=>'type',
                    'auto_submit'=>1])
            @include('components.button', ['label' => 'Switch', 'type'=>'submit', 'class' => 'button'])
        </form>
        @endif
    </div>
@endsection

@section('content-area')
    @include('app.orgs.listing')
@endsection

@section('angular-area')

{{-- <script>
(function(){
    'use strict';

    var app = angular.module('ProvisionTracker');
    app.requires.push('ProvisionTracker.Components.Button');
})();
</script> --}}
@endsection
