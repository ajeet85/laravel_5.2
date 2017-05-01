@extends('layouts.app')
@section('title', 'Resources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add Physical Resource', 'href'=>"/app/manage/$current_org->slug/digital-resources/new", 'class' => 'button'])

@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.hidden-input', ['name'=>'resource_type', 'id'=>'resource_type', 'value'=> $resource_type->pt_id])
        @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
        @include('components.hidden-input', ['name'=>'resource_pt_id', 'id'=>'resource_pt_id', 'value'=>$resource_data->pt_id])

        @include('components.text-input',
                ['label'=>'Resource Name',
                'type'=>'text',
                'name'=>'resource_name',
                'id'=>'resource_name',
                'value'=>$resource_data->name,
                'validate'=>$errors->first('resource_name')])
        @include('components.text-input',
                ['label'=>'Cost',
                'type'=>'text',
                'name'=>'resource_cost',
                'id'=>'resource_cost',
                'value'=>$resource_data->cost,
                'validate'=>$errors->first('resource_cost')])


        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
