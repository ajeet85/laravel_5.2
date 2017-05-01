@extends('layouts.app')
@section('title', 'Settings')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    User Profile
@endsection
@section('content-area-class', 'has-toolbar')
@section('content-area')

	<form action="" method="post">
		<div class="editor-area">
	        @include('components.text-input',
	                ['label'=>'First Name',
	                'type'=>'text',
	                'name'=>'first_name',
	                'id'=>'first_name',
	                'value'=>$current_user->first_name,
	                'validate' => $errors->first('first_name')])

	        @include('components.text-input',
	                ['label'=>'Last Name',
	                'type'=>'text',
	                'name'=>'last_name',
	                'id'=>'last_name',
	                'value'=>$current_user->last_name,
	                'validate' => $errors->first('last_name')])
	              
	        
	         @include('components.hidden-input',
	                ['name'=>'id',
	                'id'=>'id',
	                'value'=>$current_user->pt_id,
	                ])

      	</div>
	    <div class="tool-bar-area">
	        @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
	    </div>
	</form>
@include('app.profile.sections.email')	
@include('app.profile.listing',['title'=>'Accounts','data'=>$accs_as_options])
@include('app.profile.listing',['title'=>'Organisations','data'=>$orgs_as_options])
@include('app.profile.sections.reset-password')
@endsection