@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new Resource', 'href'=>"/app/manage/$current_org->slug/resources/new", 'class' => 'button'])

@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'Resource Name',
                'type'=>'text',
                'name'=>'resource_name',
                'id'=>'resource_name'])
        @include('components.text-input',
                ['label'=>'Cost',
                'type'=>'text',
                'name'=>'resource_cost',
                'id'=>'resource_cost'])
        @include('components.dropdown-list',[
        'name'=>'resource_type',
        'id'=>'resource_type',
        'options'=>$resource_type])
        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$current_org_id])
        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
