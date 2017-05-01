@extends('layouts.app')
@section('title', 'Assessment Types')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')

@endsection

@section('content-area')
    <form action="/app/orgs/{{$current_org->slug}}/assessment-types/{{$assessment_type->slug}}" method="post">
        @include('components.hidden-input', ['name'=>'assessment_type_id','id'=>'assessment_type_id','value'=>$assessment_type->id])
        @include('components.button', ['label' => 'Update', 'type'=>'submit', 'class' => 'button'])
        @include('components.text-input',
                ['label'=>'Assessment Type Name',
                'type'=>'text',
                'name'=>'assessment_type_name',
                'id'=>'assessment_type_name',
                'value'=>$assessment_type->name])

        <table class="listing">
            @foreach ($assessment_type_grades as $grade)
            <tr>
                <td>
                @include('components.text-input',
                        ['label'=>'Assessment Type Grade',
                        'type'=>'text',
                        'name'=>"grades[$grade->id][grade]",
                        'id'=>'org_name',
                        'value'=>$grade->public_grade])
                </td>
                <td>
                @include('components.text-input',
                        ['label'=>'Assessment Band',
                        'type'=>'text',
                        'name'=>"grades[$grade->id][band]",
                        'id'=>'org_name',
                        'value'=>$grade->band])
                </td>
                <td>
                @include('components.text-input',
                        ['label'=>'Assessment KPI',
                        'type'=>'text',
                        'name'=>"grades[$grade->id][kpi]",
                        'id'=>'org_name',
                        'value'=>$grade->kpi])
                </td>
            </tr>
            @endforeach
        </table>
    </form>
@endsection
