<?php
$position = isset($position) && !empty($position) ? $position : new RPSEMS\Models\Position();
$selectedPosition = old('parent_id', empty($parent) ? $position->parent_id : $parent->id);
?>

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
                <option value="{{ $parent->id }}" {{ $parent->id == $selectedPosition ? 'selected="selected"' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@if((int)$position->id)
    <input type="hidden" name="id" value="{{ $position->id }}" />
@endif
