
<table class="listing time-slots">
    <thead>
        <tr>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($times as $time)
    <tr class="listing-row">
        <td>
            <a href="/app/manage/{{$current_org->slug}}/time-slots/{{$time->pt_id}}">
                {{$time->name}}
            </a>
        </td>
        <td>
            {{$time->start_date}}
        </td>
        <td>
            {{$time->end_date}}
        </td>
        <td class="action">
            <form action="/app/manage/{{$current_org->slug}}/time-slots/{{$time->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input', ['name'=>'organisation_id', 'id'=>'organisation_id', 'value'=>$current_org_id])
                @include('components.hidden-input',
                        ['name'=>'pt_id',
                        'id'=>'pt_id',
                        'value'=>$time->pt_id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$times->links()}}</td></tr>
    </tbody>
</table>
