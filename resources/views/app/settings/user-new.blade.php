@extends('layouts.app')
@section('title', 'Users')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
	Add User
@endsection

@section('content-area')
	<form action="" method="post">
		<div class="editor-area">
	        @include('components.text-input',
	                ['label'=>'First Name',
	                'type'=>'text',
	                'name'=>'first_name',
	                'id'=>'first_name',
	                
	                'validate' => $errors->first('first_name')])

	        @include('components.text-input',
	                ['label'=>'Last Name',
	                'type'=>'text',
	                'name'=>'last_name',
	                'id'=>'last_name',
	                'validate' => $errors->first('last_name')])
	        @include('components.text-input',
	        		['label'=>'Email',
	        		'type'=>'text',
	        		'name'=>'email',
	        		'id'=>'email',
	        		'validate' => $errors->first('email')])
	       	@include('components.hidden-input',
	        		['name'=>'account_id',
	        		'id'=>'account_id',
	        		'value'=>$current_account_id])
      	</div>
	    <div class="tool-bar-area">
	        @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
	    </div>
@endsection


