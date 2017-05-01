<table class="listing provisions">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($provisions  as $provision)
            <tr class="listing-row">
                <td>
                    <a href="/app/manage/{{$current_org->slug}}/provisions/{{$provision->pt_id}}">
                        {{$provision->name}}
                    </a>
                </td>
                <td>
                {{$provision->description}}
                </td>
                <td>{{$provision->start_date}}</td>
                <td>{{$provision->end_date}}</td>
                <td class="action">
                    <form action="/app/manage/{{$current_org->slug}}/provision/{{$provision->pt_id}}" method="POST">
                        {{ method_field("DELETE") }}
                        @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                        @include('components.hidden-input',
                                ['name'=>'pt_id',
                                'id'=>'pt_id',
                                'value'=>$provision->pt_id])
                    </form>
                </td>
            </tr>
        @endforeach
       <tr class="pagination-row"><td>{{$provisions->links()}}</td></tr>
    </tbody>
</table>
