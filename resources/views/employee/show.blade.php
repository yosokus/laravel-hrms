@extends('layouts.default')

@section('title', 'Employee')

@include(
    'partials.content-header',
    [
        'title'=> 'Employee: '  . $employee->getName(),
        'editLink' => route('employee.edit', ['employee' => $employee]),
        'backLink' => route('employee'),
    ]
)

@section('content')
    <div class="employee-info col-sm-12">
        <fieldset class="section">
            <legend>Personal Information</legend>
            <div class="col-md-8">
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->first_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->last_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getGender() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Marital Status</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getMaritalStatus() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date of Birth</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getDisplayDateOfBirth() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone</label>
                            <div class="col-sm-8">
                                <div class="form-control-static readonly">{{ $employee->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <div class="form-control-static readonly">{{ $employee->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->address }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Date of Employment</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getDisplayDateOfEmployment() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Supervisor</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getSupervisorName() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Department</label>
                            <div class="col-sm-8">
                                <div class="form-control-static readonly">{{ $employee->getDepartmentName() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Position</label>
                            <div class="col-sm-8">
                                <div class="form-control-static">{{ $employee->getPositionName() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
@endsection


