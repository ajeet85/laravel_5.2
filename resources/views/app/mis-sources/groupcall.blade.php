@extends('layouts.app')
@section('title', 'MIS Sources')

@section('title-area')
    {!! Breadcrumbs::renderIfExists() !!}
@endsection

@section('action-area')

@endsection

@section('content-area')
    <div class="editor-area">
        <div class="service-overview">



            <div class="mis-service">
                <div class="service-logo">
                    <img src="/img/service-provider-logos/{{$service->slug}}.png" />
                </div>

                <p>{{$service->name}}</p>
                <p class="provider">Provided by <strong>{{$provider->name}}</strong></p>

                <p class="notes">
                    <strong>{{$service->notes}}</strong>
                </p>

                <form action="/app/orgs/{{$current_org->slug}}/mis-sources/{{$service->slug}}/update" method="post">
                    @include('components.hidden-input', ['name'=>'provider_id', 'id'=>'provider_id', 'value'=>$provider->id])
                    @include('components.hidden-input', ['name'=>'service_id', 'id'=>'service_id', 'value'=>$service->id])
                    @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
                    <div class="password-area">
                        @include('components.text-input',
                            ['label'=>'Username',
                            'type'=>'text',
                            'name'=>'username',
                            'id'=>'username'])

                        @include('components.text-input',
                            ['label'=>'Password',
                            'type'=>'password',
                            'name'=>'password',
                            'id'=>'password'])

                        @include('components.text-input',
                            ['label'=>'School ID',
                            'type'=>'text',
                            'name'=>'school_id',
                            'id'=>'school_id'])

                        @include('components.button', ['label' => 'Save details', 'type'=>'submit', 'class' => 'button'])

                    </div>
                </form>
            </div>


            <div class="service-description">
                <p><strong>{{$service->name}} Overview:</strong></p>
                <blockquote>
                    {{$service->description}}
                    <a href="{{$service->weblink}}">Read more ...</a>
                </blockquote>
            </div>
        </div>
    </div>
@endsection
