
{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Name</label>
    <div class="col-sm-7">
        <input name="name" class="form-control" placeholder="Position Name"
               value="{{ old('name', $position->name) }}" required />
    </div>
</div>
<div class="form-group">
    <label for="parentId" class="col-sm-3 control-label">Parent Position</label>
    <div class="col-sm-7">
        <select name="parent_id" class="form-control col-sm-7 tree-select" id="parentId" data-placeholder="- Root level position -">
            <option value="">- Root level position -</option>
            @foreach($positions as $currentPosition)
                <option value="{{ $currentPosition->id }}" {{ $currentPosition->id == $selectedParent ? 'selected="selected"' : '' }} {{ $currentPosition->parent_id ? 'data-parent=' . $currentPosition->parent_id : '' }}>{{ $currentPosition->name }}</option>
            @endforeach
        </select>
    </div>
</div>
