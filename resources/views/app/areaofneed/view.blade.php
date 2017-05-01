@extends('layouts.app')
@section('title', 'Teachers')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Edit the {{$need->name}} Need
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Import Area Of Need', 'href'=>"/app/orgs/$current_org->slug/need/import", 'class' => 'button'])
@endsection

@section('content-area')
<form action="" method="post">
    <div class="editor-area">
        <div class="panel col-1o2">
            @include('components.hidden-input', ['label'=>'', 'type'=>'hidden', 'name'=>'areaofneed_pt_id', 'id'=>'areaofneed_pt_id', 'value'=>$need->pt_id])
            @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])

            @include('components.text-input',
                    ['label'=>'Name',
                    'description' => 'Create an Area of Need that can be assigned to a Provision.',
                    'type'=>'text',
                    'name'=>'name',
                    'id'=>'name',
                    'value'=>$need->name,
                    'validate' => $errors->first('name')])

            @include('components.text-input',
                    ['label'=>'Description',
                    'type'=>'text',
                    'name'=>'areaofneed_description',
                    'id'=>'areaofneed_description',
                    'value'=>$need->description])

            @include('components.dropdown-list',
                    ['options'=>$needs_as_options,
                     'label'=>'Parent',
                     'description' => 'Create a group by adding this to an existing area of need.',
                     'name'=>'parent_id',
                     'id'=>'parent_id',
                     'selected'=>$need->parent_id])


        </div>
        <div class="panel col-2o2 bleed">
            @include('app.areaofneed.listing')
        </div>

        <div class="tool-bar-area">
            @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
        </div>
    </div>
</form>
@endsection
