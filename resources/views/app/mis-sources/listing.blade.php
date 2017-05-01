<div class="mis-services">
    @foreach ($services as $service)
        <div class="mis-service">
            <div class="service-logo">
                <img src="/img/service-provider-logos/{{$service->slug}}.png" />
            </div>
            @include('components.radio',
                    ['label'=>$service->name,
                    'name'=>'service',
                    'id' => $service->slug,
                    'value'=>$service->id])

            <p class="provider">Provided by <strong>{{$service->provider_name}}</strong></p>
            <form action="/app/orgs/{{$current_org->slug}}/mis-sources/{{$service->slug}}" method="post">
                @include('components.hidden-input', ['name'=>'provider_id', 'id'=>'provider_id', 'value'=>$service->provider_id])
                @include('components.hidden-input', ['name'=>'service_id', 'id'=>'service_id', 'value'=>$service->id])
                @include('components.button', ['label' => 'Continue', 'type'=>'submit', 'class' => 'button'])
            </form>
        </div>

    @endforeach
</div>
