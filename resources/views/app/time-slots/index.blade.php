@extends('layouts.app')
@section('title', 'Time Slots')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link',
            ['text' => 'Add new Time Slot',
            'href'=>"/app/manage/$current_org->slug/time-slots/new",
            'class' => 'button has-icon', 'icon'=>'fa-plus-circle'])
@endsection

@section('content-area')
    @include('app.time-slots.listing')
@endsection
