@extends('layouts.app')
@section('title', 'Schedule')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')

@endsection

@section('content-area-class', 'has-toolbar')
@section('content-area')
	Date : {{ $schedule_date }} <br>

	@foreach($provisions as $provision)
		Provision Name :  {{ $provision->name }} <br>
		Provision Time :  {{ $provision['start_time'] }} - {{ $provision['end_time'] }} <br>
	@endforeach

@endsection
