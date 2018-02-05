@if ($employees->count())
    <table id="employees" class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="80px">#</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Supervisor</th>
                <th>Supervised</th>
                <th class="action-column" width="250px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('employee.show', ['employee' => $employee]) }}">{{ $employee->getName() }}</a>
                    </td>
                    <td>
                        @if ($employee->department)
                            <a href="{{ route('department.show', ['employee' => $employee->department]) }}">{{ $employee->department->name }}</a>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if ($employee->position)
                            <a href="{{ route('position.show', ['employee' => $employee->position]) }}">{{ $employee->position->name }}</a>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if ($employee->supervisor)
                            <a href="{{ route('employee.show', ['employee' => $employee]) }}">{{ $employee->supervisor->name }}</a>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td><span class="badge badge-info">{{ $employee->isSupervisor() }}</span></td>
                    <td>
                        <form class="delete-icon delete-record form-inline" id="{{ $employee->id }}" action="{{ route('employee.delete', ['employee' => $employee]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="btn-group">
                                <a class="btn btn-default" href="{{ route('employee.show', ['employee' => $employee]) }}"><i class="fa fa-info"></i> Info</a>
                                <a class="btn btn-info" href="{{ route('employee.edit', ['employee' => $employee]) }}"><i class="fa fa-edit"></i> Edit</a>
                                <button title="Delete" class="btn btn-warning delete-confirmation"
                                        name="deleteType"
                                        value="default">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p><a href="{{ route('employee.create') }}">Create an employee</a></p>
@endif


