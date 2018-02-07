
{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Name</label>
    <div class="col-sm-7">
        <input name="name" class="form-control" placeholder="Position Name"
               value="{{ old('name', $position->name) }}" required="required" />
    </div>
</div>
<div class="form-group">
    <label for="parentId" class="col-sm-3 control-label">Parent Position</label>
    <div class="col-sm-7">
        <select name="parent_id" class="form-control col-sm-7" id="parentId">
            <option value="">---</option>
            @foreach($positions as $parent)
                <option value="{{ $parent->id }}" {{ $parent->id == $selectedParent ? 'selected="selected"' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
</div>
