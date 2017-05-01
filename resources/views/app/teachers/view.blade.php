@extends('layouts.app')
@section('title', 'Teachers')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new staff', 'href'=>"/app/orgs/$current_org->slug/teacher/new", 'class' => 'button'])
@endsection

@section('content-area')
<div class="editor-area">
	<form action="" method="post">
        @include('components.text-input',
                ['label'=>'First Name',
                'type'=>'text',
                'name'=>'first_name',
                'id'=>'first_name',
                'value'=>$staff_details->first_name,
                'validate'=>$errors->first('first_name')])

        @include('components.text-input',
                ['label'=>'Last Name',
                'type'=>'text',
                'name'=>'last_name',
                'id'=>'last_name',
                'value'=>$staff_details->last_name,
                'validate'=>$errors->first('last_name')])

        @include('components.text-input',
                ['label'=>'Description',
                'type'=>'text',
                'name'=>'staff_description',
                'id'=>'staff_description',
                'value'=>$staff_details->description])

        @if( $staff_details->provider == 'yes')
            @include('components.checkbox',
                    ['label'=>'Is this member of staff a Provider?',
                    'value'=>'yes',
                    'name'=>"is_provider" ,
                    'id'=>'is_provider',
                    'checked'=>'checked'])
        @else
            @include('components.checkbox',
                    ['label'=>'Is this member of staff a Provider?',
                    'value'=>'yes',
                    'name'=>"is_provider" ,
                    'id'=>'is_provider'])
        @endif

       @include('components.text-input',
                ['label'=>'Cost',
                'type'=>'text',
                'name'=>'staff_cost',
                'id'=>'staff_cost',
                'value'=>$staff_details->cost,
                'validate'=>$errors->first('staff_cost')])

        @include('components.hidden-input',
                ['name'=>'organisation_id',
                'id'=>'organisation_id',
                'value'=>$staff_details->organisation_id])
         @include('components.hidden-input',
                ['name'=>'staff_pt_id',
                'id'=>'staff_pt_id',
                'value'=>$staff_details->pt_id])
        @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
