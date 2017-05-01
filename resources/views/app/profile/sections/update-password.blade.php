@extends('layouts.app')
@section('title', 'Settings')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    New Password
@endsection
@section('content-area-class', 'has-toolbar')
@section('content-area')

	<form action="" method="post">
		<div class="editor-area">
	       

	        @include('components.text-input',
	                ['label'=>'New Password',
	                'type'=>'password',
	                'name'=>'password',
	                'id'=>'password',
	                'validate' => $errors->first('password')])

	        @include('components.text-input',
	                ['label'=>'Confirm Password',
	                'type'=>'password',
	                'name'=>'password_confirmation',
	                'id'=>'password_confirmation',
	                'validate' => $errors->first('password_confirmation')])
	              
	        
	         @include('components.hidden-input',
	                ['name'=>'id',
	                'id'=>'id',
	                'value'=>$current_user->id,
	                ])

      	</div>
	    <div class="tool-bar-area">
	        @include('components.button', ['label' => 'Update Password', 'type'=>'submit', 'class' => 'button'])
	    </div>
	</form>

@endsection