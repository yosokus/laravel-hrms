
{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Name</label>
    <div class="col-sm-7">
        <input name="name" class="form-control" placeholder="Department Name"
               value="{{ old('name', $department->name) }}" required />
    </div>
</div>
<div class="form-group">
    <label for="parentId" class="col-sm-3 control-label">Parent Department</label>
    <div class="col-sm-7">
        <select name="parent_id" class="form-control col-sm-7 tree-select" id="parentId" data-placeholder="- Root level department -">
            <option value="">- Root level department -</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ $dept->id == $selectedParent ? 'selected="selected"' : '' }} {{ $dept->parent_id ? 'data-parent=' . $dept->parent_id : '' }}>{{ $dept->name }}</option>
            @endforeach
        </select>
    </div>
</div>
