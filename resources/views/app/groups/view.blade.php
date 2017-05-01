@extends('layouts.app')
@section('title', 'Groups')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new vulnerable group', 'href'=>"/app/orgs/$current_org->slug/vulnerbale-groups/new", 'class' => 'button'])

@endsection

@section('content-area')
<div class="editor-area">
	<form action="" method="post">
        @include('components.text-input',
                ['label'=>'Group Name',
                'type'=>'text',
                'name'=>'group_name',
                'id'=>'group_name',
                'value'=>$group_detail->name,
                'validate' => $errors->first('group_name')])

        @include('components.text-input',
                ['label'=>'Group Description',
                'type'=>'text',
                'name'=>'description',
                'id'=>'description',
                'value'=>$group_detail->description,
                'validate' => $errors->first('description')])



        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$group_detail->organisation_id])
         @include('components.hidden-input',
                ['name'=>'class_pt_id',
                'id'=>'class_pt_id',
                'value'=>$group_detail->pt_id])
        @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
