@extends('layouts.app')
@section('title', 'Classes')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
    @include('components.link', ['text' => 'Add new class', 'href'=>"/app/orgs/$current_org->slug/classes/new", 'class' => 'button'])

@endsection

@section('content-area')
    <div class="editor-area">
    	<form action="" method="post">
            @include('components.hidden-input', ['name'=>'class_pt_id', 'id'=>'class_pt_id', 'value'=>$class_detail->pt_id])
            @include('components.hidden-input', ['name'=>'class_id', 'id'=>'class_id', 'value'=>$class_detail->id])
            @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$class_detail->organisation_id])
            <div class="panel col-1o2">
                <div class="class">
                    <div class="class-core-details">
                    @include('components.text-input',
                            ['label'=>'Class Name',
                            'type'=>'text',
                            'name'=>'class_name',
                            'id'=>'class_name',
                            'value'=>$class_detail->class_name,
                            'validate' => $errors->first('class_name')])

                    @include('components.text-input',
                            ['label'=>'Academic Year',
                            'type'=>'text',
                            'name'=>'academic_year',
                            'id'=>'academic_year',
                            'value'=>$class_detail->academic_year,
                            'validate' => $errors->first('academic_year')])

                    @include('components.dropdown-list',
                            ['options'=>$subjects,
                            'name'=>'subject_id',
                            'id'=>'subject_id',
                            'selected'=>$class_detail->subject_id,
                            'validate' => $errors->first('subject_id')])
                    </div>
                </div>
                @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
            </div>
            <div class="panel col-2o2">
                @include('app.classes.student-classlist')
                <br>
                @include('app.classes.staff-classlist')
            </div>
        </form>
    </div>

@endsection
