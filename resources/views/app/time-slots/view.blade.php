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

@section('content-area-class', 'has-toolbar')
@section('content-area')
    <form action="" method="post">
        @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
        <div class="editor-area">
            <div class="panel">
            @include('components.text-input',
                    ['label'=>'Name',
                    'description' => 'Give this Time Slot a name so you can assign it to a provision',
                    'type'=>'text',
                    'name'=>'name',
                    'id'=>'name',
                    'value'=>$time->name])

            <div class="input-group split2">
                @include('components.text-input',
                        ['label'=>'Start date',
                        'type'=>'text',
                        'name'=>'start_date',
                        'id'=>'start_date',
                        'value'=>$time->start_date])

                
            </div>

            <div class="section">
                <div class="input-group split2">
                    @include('components.text-input',
                            ['label'=>'Start time',
                            'type'=>'text',
                            'name'=>'start_time',
                            'id'=>'start_time',
                            'value'=>$time->start_time])

                    @include('components.text-input',
                            ['label'=>'End time',
                            'type'=>'text',
                            'name'=>'end_time',
                            'id'=>'end_time',
                            'value'=>$time->end_time])
                </div>
            </div>

            <div class="section">
                 <p class="title">
                    Do you want to repeat this event?
                </p>
            </div>

            <div class="section">
                @include('components.radio',
                        ['label'=>'Every day',
                        'name'=>'repeat',
                        'id'=>'daily',
                        'value'=>'daily',
                        'selected'=>$time->repeating])

                @include('components.radio',
                        ['label'=>'Every week',
                        'name'=>'repeat',
                        'id'=>'weekly',
                        'value'=>'weekly',
                        'selected'=>$time->repeating])

                @include('components.radio',
                        ['label'=>'Every Term',
                        'name'=>'repeat',
                        'id'=>'termly',
                        'value'=>'termly',
                        'selected'=>$time->repeating])

                @include('components.radio',
                        ['label'=>'Every Month',
                        'name'=>'repeat',
                        'id'=>'monthly',
                        'value'=>'monthly',
                        'selected'=>$time->repeating])

                @include('components.radio',
                        ['label'=>'Every Year',
                        'name'=>'repeat',
                        'id'=>'yearly',
                        'value'=>'yearly',
                        'selected'=>$time->repeating])
            </div>
            </div>
        </div>
        @include('components.text-input',
                        ['label'=>'End date',
                        'type'=>'text',
                        'name'=>'end_date',
                        'id'=>'end_date',
                        'value'=>$time->end_date])

        <div class="tool-bar-area">
            @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
        </div>
    </form>
@endsection
