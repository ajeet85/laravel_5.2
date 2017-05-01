<ul class="areas-of-need">
@if( isset($needs) )
    @foreach ($needs as $need)
         <li>
            <a href="/app/orgs/{{$current_org->slug}}/needs/{{$need->pt_id}}">
                <span>
                    {{$need->name}}
                </span>
                <form action="/app/orgs/{{$current_org->slug}}/needs/{{$need->pt_id}}" method="POST">
                    {{ method_field("DELETE") }}
                    @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                    @include('components.hidden-input',
                            ['name'=>'pt_id',
                            'id'=>'pt_id',
                            'value'=>$need->pt_id])
                </form>
            </a>
            @if( count($need->children) > 0 )
                <ul>
                    @include('app.areaofneed.listing-child', ['needs'=>$need->children, 'level'=>2])
                </ul>
            @endif
        </li>
     @endforeach
 @endif
 </ul>
