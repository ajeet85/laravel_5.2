@foreach ($needs as $need)
    <li>
       <a style="padding-left:{{$level*20}}px;" href="/app/orgs/{{$current_org->slug}}/needs/{{$need->pt_id}}">
           <span>
               {{$need->name}}
               <form action="/app/orgs/{{$current_org->slug}}/needs/{{$need->pt_id}}" method="POST">
                   {{ method_field("DELETE") }}
                   @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                   @include('components.hidden-input',
                           ['name'=>'pt_id',
                           'id'=>'pt_id',
                           'value'=>$need->pt_id])
               </form>
           </span>
       </a>
       @if( count($need->children) > 0 )
           <ul>
               @include('app.areaofneed.listing-child', ['needs'=>$need->children, 'level'=>($level+1)])
           </ul>
       @endif
   </li>
@endforeach
