@if ($positions->count())
    <table id="positions" class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="100px">#</th>
                <th>Name</th>
                <th class="text-center"># sub positions</th>
                <th class="action-column" width="350px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($positions as $position)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $position->name }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $position->sub_positions_count }}</span></td>

                    <td>
                        <form class="delete-icon delete-record form-inline" id="{{ $position->id }}" action="{{ route('position.destroy', ['position' => $position]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value="{{ $position->id }}">
                            <div class="btn-group">
                                <a class="btn btn-default" href="{{ route('position.show', ['position' => $position]) }}"><i class="fa fa-info"></i> Info</a>
                                <a class="btn btn-info" href="{{ route('position.edit', ['position' => $position]) }}"><i class="fa fa-edit"></i> Edit</a>
                                <button title="Delete" class="btn btn-warning delete-confirmation"
                                        name="deleteType"
                                        value="default">
                                    <i class="glyphicon glyphicon-trash"></i> Delete
                                </button>
                                @if ($position->sub_positions_count)
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
    <p><a href="{{ route('position.create') }}">Create a position</a></p>
@endif


