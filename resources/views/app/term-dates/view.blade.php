
@extends('layouts.app')
@section('title', 'Assessment Types')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('filter-area')
    Create a new Term Date
@endsection
@section('action-area')

@endsection

@section('content-area')
<form action="" method="post">
    <div class="editor-area">
        @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
        @include('components.hidden-input', ['name'=>'id', 'id'=>'id', 'value'=>$term->id])

        @include('components.text-input',
                ['label'=>'Term Name',
                'type'=>'text',
                'name'=>'term_name',
                'id'=>'term_name',
                'value'=>$term->name,
                'validate'=>$errors->first('term_name')])

        @include('components.text-input',
                ['label'=>'When does this Term start?',
                'description' => 'Dates can be written using most common formats.
                                  We will translate them into useable dates.
                                  For example: Monday 5th November',
                'type'=>'text',
                'name'=>'start_date',
                'id'=>'start_date',
                'value'=>$term->start_date,
                'validate'=>$errors->first('start_date')])

        @include('components.text-input',
                ['label'=>'When does this Term end?',
                'description' => 'Dates can be written using most common formats.
                                  We will translate them into useable dates.
                                  For example: Friday 9th November',
                'type'=>'text',
                'name'=>'end_date',
                'id'=>'end_date',
                'value'=>$term->end_date,
                'validate'=>$errors->first('end_date')])

    </div>
    <div class="tool-bar-area">
        @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
    </div>
</form>
@endsection
