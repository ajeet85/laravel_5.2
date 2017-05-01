@inject('utils', 'App\Providers\ProvisionTracker\UtilsServiceInterface')
<table class="listing students">
    <thead>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Date of birth</th>
            <th class="action"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($students as $student)
    <tr class="listing-row">
        <td>
            <a href="/app/orgs/{{$current_org->slug}}/pupils/{{$student->pt_id}}">
                {{$student->first_name}} {{$student->last_name}}
            </a>
        </td>
        <td>{{$student->gender}}</td>
        <td>{{$utils->formatDate($student->date_of_birth)}}</td>
        <td class="action">
            <form action="/app/orgs/{{$current_org->slug}}/pupils/{{$student->pt_id}}" method="POST">
                {{ method_field("DELETE") }}
                @include('components.button', ['label' => 'Delete', 'type'=>'submit', 'class' => 'button icon-only', 'icon'=>'fa-trash'])
                @include('components.hidden-input',
                        ['name'=>'id',
                        'id'=>'id',
                        'value'=>$student->id])
            </form>
        </td>
    </tr>
    @endforeach
    <tr class="pagination-row"><td>{{$students->links()}}</td></tr>
    </tbody>
</table>
