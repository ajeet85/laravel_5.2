@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new Resource', 'href'=>"/app/orgs/$current_org->slug/resources/new", 'class' => 'button'])

@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'Resource Name',
                'type'=>'text',
                'name'=>'resource_name',
                'id'=>'resource_name',
                'value'=>$resource_data->name])
        @include('components.text-input',
                ['label'=>'Cost',
                'type'=>'text',
                'name'=>'resource_cost',
                'id'=>'resource_cost',
                'value'=>$resource_data->cost])
        @include('components.dropdown-list',[
        'name'=>'resource_type',
        'id'=>'resource_type',
        'options'=>$resource_type,
        'selected'=>$resource_data->resource_type_pt_id])
        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$current_org_id])
        @include('components.hidden-input',
                ['name'=>'resource_pt_id',
                'id'=>'resource_pt_id',
                'value'=>$resource_data->pt_id])
        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
