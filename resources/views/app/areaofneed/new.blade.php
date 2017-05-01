@extends('layouts.app')
@section('title', 'Area Of Need')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
     @include('components.link', ['text' => 'Add Area Of Need', 'href'=>"/app/orgs/$current_org->slug/needs/new", 'class' => 'button'])

@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'Name',
                'type'=>'text',
                'name'=>'name',
                'id'=>'name',
                'validate'=>$errors->first('name')])

        @include('components.text-input',
                ['label'=>'Description',
                'type'=>'text',
                'name'=>'areaofneed_description',
                'id'=>'areaofneed_description'])

        @include('components.dropdown-list',
                ['options'=>$needs,
                 'name'=>'parent_id',
                 'id'=>'parent_id'])


        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$current_org_id])
        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
