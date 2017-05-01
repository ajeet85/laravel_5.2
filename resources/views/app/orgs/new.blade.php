@extends('layouts.app')
@section('title', 'Organisations')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new organisation', 'href'=>'/app/orgs/new', 'class' => 'button'])
@endsection

@section('content-area-class', 'has-toolbar')
@section('content-area')
<form action="" method="post">
    <div class="editor-area">
            @include('components.text-input',
                    ['label'=>'Organisation Id',
                    'type'=>'text',
                    'name'=>'org_id',
                    'id'=>'org_id',
                    'validate'=>$errors->first('org_id')])

            @include('components.text-input',
                    ['label'=>'Organisation Name',
                    'type'=>'text',
                    'name'=>'org_name',
                    'id'=>'org_name',
                    'validate'=>$errors->first('org_name')])

            @include('components.text-input',
                    ['label'=>'Organisation Address',
                    'type'=>'text',
                    'name'=>'org_address',
                    'id'=>'org_address',
                    'validate'=>$errors->first('org_address')])

            @include('components.hidden-input',
                    ['name'=>'account_id',
                    'id'=>'account_id',
                    'value'=>$current_account_id,
                    'validate'=>$errors->first('account_id')])

            @include('components.dropdown-list', ['name'=>'org_type', 'id'=>'org_type', 'options'=>$org_types,'validate'=>$errors->first('org_type')])

    </div>
    <div class="tool-bar-area">
        @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
    </div>
</form>

@include('app.orgs.sections.term')
@include('app.orgs.sections.group')
@include('app.orgs.sections.need')
@include('app.orgs.sections.assesments')
@endsection
