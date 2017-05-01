@inject('utils', 'App\Providers\ProvisionTracker\UtilsServiceInterface')
@extends('layouts.app')
@section('title', 'Pupils')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')
      @include('components.link', ['text' => 'Add new pupil', 'href'=>'/app/orgs/$current_org->slug/pupil/new', 'class' => 'button'])
@endsection

@section('content-area')
<div class="editor-area">
    <form action="" method="post">
        @include('components.text-input',
                ['label'=>'First Name',
                'type'=>'text',
                'name'=>'first_name',
                'id'=>'first_name',
                'value'=>$student->first_name,
                'validate'=>$errors->first('first_name')])

        @include('components.text-input',
                ['label'=>'Last Name',
                'type'=>'text',
                'name'=>'last_name',
                'id'=>'last_name',
                'value'=>$student->last_name,
                'validate'=>$errors->first('last_name')])

        @include('components.text-input',
                ['label'=>'Student ID',
                'type'=>'text',
                'name'=>'student_id',
                'id'=>'student_id',
                'value'=>$student->student_id,
                'validate'=>$errors->first('student_id')])

        @include('components.text-input',
                ['label'=>'Date of Birth',
                'type'=>'text',
                'name'=>'date_of_birth',
                'id'=>'date_of_birth',
                'value'=>$utils->formatDate($student->date_of_birth),
                'validate'=>$errors->first('date_of_birth')])

        @include('components.radio',
                ['label'=>'Female',
                'name'=>'gender',
                'value'=>'female',
                'selected'=>$student->gender])

        @include('components.radio',
                ['label'=>'Male',
                'name'=>'gender',
                'value'=>'male',
                'selected'=>$student->gender])

        @include('components.text-area',
                ['name'=>'description',
                'id'=>'description',
                'content'=>$student->description])

        @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
    </form>
</div>
@endsection
