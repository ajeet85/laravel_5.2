@extends('layouts.app')
@section('title', 'Settings')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Update Email
@endsection
@section('content-area-class', 'has-toolbar')
@section('content-area')

	<form action="" method="post">
		<div class="editor-area">
	       

	        @include('components.text-input',
	                ['label'=>'Email',
	                'type'=>'text',
	                'name'=>'email',
	                'id'=>'email',
	                'validate' => $errors->first('email')])

	        
	              
	        
	         @include('components.hidden-input',
	                ['name'=>'id',
	                'id'=>'id',
	                'value'=>$current_user->id,
	                ])

      	</div>
	    <div class="tool-bar-area">
	        @include('components.button', ['label' => 'Update Email', 'type'=>'submit', 'class' => 'button'])
	    </div>
	</form>

@endsection