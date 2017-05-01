@extends('layouts.app')
@section('title', 'Organisations')

@section('title-area')
   {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'View Groups', 'href'=>"/app/orgs/$current_org->slug/vulnerbale-groups", 'class' => 'button'])
@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'Group Name',
                'type'=>'text',
                'name'=>'group_name',
                'id'=>'group_name',
                'validate' => $errors->first('group_name')])

        @include('components.text-input',
                ['label'=>'Description',
                'type'=>'text',
                'name'=>'description',
                'id'=>'description',
                'validate' => $errors->first('description')])


        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$current_org_id])
        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
