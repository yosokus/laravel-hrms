<?php
$department = isset($department) && !empty($department) ? $department : new RPSEMS\Models\Department();
$selectedDepartment = old('parent_id', empty($parent) ? $department->parent_id : $parent->id);
?>

{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Name</label>
    <div class="col-sm-7">
        <input name="name" class="form-control" placeholder="Department Name"
               value="{{ old('name', $department->name) }}" required="required" />
    </div>
</div>
<div class="form-group">
    <label for="parentId" class="col-sm-3 control-label">Parent Department</label>
    <div class="col-sm-7">
        <select name="parent_id" class="form-control col-sm-7" id="parentId">
            <option value="">---</option>
            @foreach($departments as $parent)
                <option value="{{ $parent->id }}" {{ $parent->id == $selectedDepartment ? 'selected="selected"' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@if((int)$department->id)
    <input type="hidden" name="id" value="{{ $department->id }}" />
@endif
