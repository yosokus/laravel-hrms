
{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">First Name</label>
    <div class="col-sm-7">
        <input name="first_name" class="form-control" placeholder="First Name"
               value="{{ old('first_name', $employee->first_name) }}" required />
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-sm-3 control-label">Last Name</label>
    <div class="col-sm-7">
        <input name="last_name" class="form-control" placeholder="Last Name"
               value="{{ old('last_name', $employee->last_name) }}" required />
    </div>
</div>
<div class="form-group">
    <label for="gender" class="col-sm-3 control-label">Gender</label>
    <div class="col-sm-7 col-md-3">
        <select name="gender" class="form-control col-sm-7" id="gender">
            @foreach($genderOptions as $genderId => $genderOption)
                <option value="{{ $genderId }}" {{ $genderId == $selectedGender ? 'selected="selected"' : '' }}>{{ $genderOption }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="marital_status" class="col-sm-3 control-label">Marital Status</label>
    <div class="col-sm-7 col-md-3">
        <select name="marital_status" class="form-control col-sm-7" id="maritalStatus">
            @foreach($maritalStatusOptions as $maritalStatusId => $maritalStatusOption)
                <option value="{{ $maritalStatusId }}" {{ $maritalStatusId == $selectedMaritalStatus ? 'selected="selected"' : '' }}>{{ $maritalStatusOption }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="date_of_birth" class="col-sm-3 control-label">Date of Birth</label>
    <div class="col-sm-7 col-md-3">
        <input name="date_of_birth" class="form-control date-picker" data-date-format="{{ $dateFormat }}"
               value="{{ old('date_of_birth', $employee->getDisplayDateOfBirth()) }}"
               data-date-end-date="{{ $dateOfBirthEndDate }}" />
    </div>
</div>
<div class="form-group">
    <label for="phone" class="col-sm-3 control-label">Phone</label>
    <div class="col-sm-7">
        <input name="phone" class="form-control" placeholder="Phone" value="{{ old('phone', $employee->phone) }}" />
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-sm-3 control-label">Email</label>
    <div class="col-sm-7">
        <input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email', $employee->email) }}" />
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-sm-3 control-label">Address</label>
    <div class="col-sm-7">
        <input name="address" class="form-control" placeholder="Address" value="{{ old('address', $employee->address) }}" />
    </div>
</div>
<div class="form-group">
    <label for="date_of_employment" class="col-sm-3 control-label">Date of Employment</label>
    <div class="col-sm-7 col-md-3">
        <input name="date_of_employment" class="form-control date-picker" data-date-format="{{ $dateFormat }}"
               value="{{ old('date_of_employment', $employee->getDisplayDateOfEmployment()) }}"
               data-date-end-date="{{ $dateOfEmploymentEndDate }}"/>
    </div>
</div>
<div class="form-group">
    <label for="supervisorId" class="col-sm-3 control-label">Supervisor</label>
    <div class="col-sm-7">
        <select name="supervisor_id" class="form-control col-sm-7" id="supervisorId">
            <option value="">- Select Supervisor -</option>
            @foreach($employees as $supervisor)
                <option value="{{ $supervisor->id }}" {{ $supervisor->id == $selectedSupervisor ? 'selected="selected"' : '' }}>{{ $supervisor->getName() }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="departmentId" class="col-sm-3 control-label">Deparment</label>
    <div class="col-sm-7">
        <select name="department_id" class="form-control col-sm-7 tree-select" id="departmentId" data-placeholder="- Select Department -">
            <option value="">- Select Department -</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ $department->id == $selectedDepartment ? 'selected="selected"' : '' }} {{ $department->parent_id ? 'data-parent=' . $department->parent_id : '' }}>{{ $department->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="positionId" class="col-sm-3 control-label">Position</label>
    <div class="col-sm-7">
        <select name="position_id" class="form-control col-sm-7 tree-select" id="positionId" data-placeholder="- Select Position -">
            <option value="">- Select Position -</option>
            @foreach($positions as $position)
                <option value="{{ $position->id }}" {{ $position->id == $selectedPosition ? 'selected="selected"' : '' }} {{ $position->parent_id ? 'data-parent=' . $position->parent_id : '' }}>{{ $position->name }}</option>
            @endforeach
        </select>
    </div>
</div>
