@extends('layouts.app')
@section('title', 'Permissions')

@section('title-area')
    Settings / Users / {{$user->first_name}} {{$user->last_name}} / Permissions
@endsection

@section('action-area')

@endsection

@section('content-area')

    <form action="" method="post">
        @include('components.hidden-input', ['name'=>'id','id'=>'id', 'value'=>$user->id])
        @include('components.hidden-input', ['name'=>'account','id'=>'account', 'value'=>$org_account->id])
        @include('components.hidden-input', ['name'=>'context','id'=>'context', 'value'=>$current_org->id])
        @include('components.button', ['label' => 'Save', 'type'=>'submit', 'class' => 'button'])
        <table class="permissions">
            <thead>
                <tr>
                    <th>{{$user->first_name}} can</th>
                    @foreach ($permission_actions as $action)
                    <th>{{$action->label}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($permission_elements as $element)
                    <tr>
                        <td>{{$element->label}}</td>
                        @foreach ($permission_actions as $action)
                           @if( $permissions[$element->label][$action->label] == 'granted')
                                <td>@include('components.checkbox', [
                                                'value'=>'yes',
                                                'name'=>"permissions[$action->label][$element->label]" ,
                                                'id'=>$action->label ."_". $element->label,
                                                'checked'=>'checked'])
                                </td>
                            @else
                                <td>@include('components.checkbox', [
                                                'value'=>'yes',
                                                'name'=>"permissions[$action->label][$element->label]" ,
                                                'id'=>$action->label ."_". $element->label])
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
@endsection
