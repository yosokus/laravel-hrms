@if ($departments->count())
    <table id="departments" class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="100px">#</th>
                <th>Name</th>
                <th class="text-center"># sub departments</th>
                <th class="action-column" width="350px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $department->name }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $department->sub_departments_count }}</span></td>

                    <td>
                        <form class="delete-icon delete-record form-inline" id="{{ $department->id }}" action="{{ route('department.destroy', ['department' => $department]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value="{{ $department->id }}">
                            <div class="btn-group">
                                <a class="btn btn-default" href="{{ route('department.show', ['department' => $department]) }}"><i class="fa fa-info"></i> Info</a>
                                <a class="btn btn-info" href="{{ route('department.edit', ['department' => $department]) }}"><i class="fa fa-edit"></i> Edit</a>
                                <button title="Delete" class="btn btn-warning delete-confirmation"
                                        name="deleteType"
                                        value="default">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </button>
                                @if ($department->sub_departments_count)
                                    <button title="Delete All" class="btn btn-danger delete-all-confirmation"
                                            name="deleteType"
                                            value="all">
                                        <i class="glyphicon glyphicon-trash"></i> Delete All
                                    </button>
                                @endif
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p><a href="{{ route('department.create') }}">Create a department</a></p>
@endif


