@extends('layouts.app')
@section('title', 'Provisions')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Create a new Provision
@endsection

@section('action-area')
@endsection

@section('content-area-class', 'has-toolbar')
@section('content-area')
    <form action="" method="post">
        <div class="editor-area">
            @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
            <div class="panel col-1o2">

                @include('components.text-input',
                        ['label'=>'Name',
                        'description'=>'Give this Provision a unique name.',
                        'type'=>'text',
                        'name'=>'name',
                        'id'=>'name',
                        'validate'=>$errors->first('name'),
                        'value'=>$provision->name])

                @include('components.text-input',
                        ['label'=>'Description',
                        'description'=>'What is this Provision for?',
                        'type'=>'text',
                        'name'=>'description',
                        'id'=>'description',
                        'value'=>$provision->descriptions])

                @include('app.provisions.sections')

            </div>

            <div class="panel col-2o2 bleed">
                <div class="provision-resources">
                    <span class="provision-resources-header">Available Resources</span>
                    @include('app.provisions.assets')
                </div>
            </div>
        </div>

        <div class="tool-bar-area">
            @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
        </div>
    </form>
@endsection
