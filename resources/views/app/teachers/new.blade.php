@extends('layouts.app')
@section('title', 'Teachers')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new staff', 'href'=>'/app/orgs/$current_org->slug/teacher/new', 'class' => 'button'])
@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'First Name',
                'type'=>'text',
                'name'=>'first_name',
                'id'=>'first_name',
                'validate'=>$errors->first('first_name')])

        @include('components.text-input',
                ['label'=>'Last Name',
                'type'=>'text',
                'name'=>'last_name',
                'id'=>'last_name',
                'validate'=>$errors->first('last_name')])

        @include('components.text-input',
                ['label'=>'Description',
                'type'=>'text',
                'name'=>'staff_description',
                'id'=>'staff_description'])

       @include('components.text-input',
                ['label'=>'Cost',
                'type'=>'text',
                'name'=>'staff_cost',
                'id'=>'staff_cost',
                'validate'=>$errors->first('staff_cost')])

        @include('components.radio',
                ['label'=>'Provider',
                'name'=>'is_provider',
                'id'=>'is_provider',
                'value'=>'yes',
                'selected'=>'yes',
                'validate'=>$errors->first('is_provider')])

         @include('components.radio',
                ['label'=>'Not a Provider',
                'name'=>'is_provider',
                'id'=>'is_provider',
                'value'=>'no',
                'validate'=>$errors->first('is_provider')])

        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$current_org_id])
        @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
