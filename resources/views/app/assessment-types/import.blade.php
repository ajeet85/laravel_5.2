@extends('layouts.app')
@section('title', 'Assessment Types')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
	 @include('components.link', ['text' => 'Download Template', 'href'=>"/app/orgs/$current_org->slug/assessment-type/download-template", 'class' => 'button'])
@endsection

@section('content-area')
    <div class="editor-area">
        <div class="panel col-1o2">
        	<form method="post" action="/app/orgs/{{$current_org->slug}}/assessment-type/import" enctype="multipart/form-data">
        		@include('components.text-input',
                        ['type'=>'file',
                        'name'=>'file_name',
                        'id'=>'file_name',
                        ])
                 @include('components.button', ['label' => 'Submit', 'type'=>'submit', 'class' => 'button'])
        	</form>
        </div>
    </div>
@endsection
