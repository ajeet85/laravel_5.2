<table class="listing classes">
    <thead>
        <tr>
            <th>Class Name</th>
            <th>Academic Year</th>
            <th>Staff Member</th>
            <th>Subject Name</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($class_details as $class_detail)

    <tr class="listing-row">
        <td><a href="/app/orgs/{{$current_org->slug}}/classes/{{$class_detail->pt_id}}">{{$class_detail->class_name}}</a></td>
        <td>{{$class_detail->academic_year}}</td>
        <td>{{$class_detail->staff_name}}</td>
        <td>{{$class_detail->subject_name}}</td>
        <td class="action">
            <form action="/app/orgs/{{$current_org->slug}}/classes/{{$class_detail->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input',
                        ['name'=>'pt_id',
                        'id'=>'pt_id',
                        'value'=>$class_detail->pt_id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$class_details->links()}}</td></tr>
    </tbody>
</table>
