<?php

namespace RPSEMS\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use RPSEMS\Models\Employee;
use RPSEMS\Models\Department;
use RPSEMS\Models\Position;

class EmployeeController extends AbstractController
{
    /**
     * constructor.
     */
    public function __construct()
    {
        parent::__construct('employee');
    }

    /**
     * @return View
     */
    public function index() {
        return view(
            $this->getView('index'),
            [
                'employees' => Employee::orderBy('first_name')->orderBy('last_name')->get()
            ]
        );
    }

    /**
     * @param Employee $employee
     * @return View
     */
    public function show(Employee $employee) {
        return view(
            $this->getView('show'),
            [
                'employee' => $employee
            ]
        );
    }

    /**
     * @return View
     */
    public function create() {
        return view(
            $this->getView('create'),
            $this->getFormData()
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request) {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails()) {
            return redirect()->action('EmployeeController@create')->withErrors($validator)->withInput();
        }
        $employee = new Employee();
        $this->setData($employee);
        $employee->save();

        return redirect()->action('EmployeeController@index')->with('message', 'Employee created');
    }

    /**
     * @param Employee $employee
     * @return View
     */
    public function edit(Employee $employee)
    {
        return view(
            $this->getView('edit'),
            $this->getFormData($employee)
        );
    }

    /**
     * @param Request $request
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Employee $employee)
    {
        /** @var \Illuminate\Contracts\Validation\Validator $validator */
        $validator = $this->validateForm($request);
        if ($validator->fails())  {
            return redirect()
                ->action('EmployeeController@edit', ['employee' => $employee->id])
                ->withErrors($validator)
                ->withInput();
        }
        $this->setData($employee);
        $employee->save();

        return redirect()->action('EmployeeController@index')->with('message', 'Employee ' . $employee->getName() . ' updated');
    }

    /**
     * @param Employee $employee
     *
     * @return RedirectResponse
     */
    public function delete(Employee $employee)
    {
        $name = $employee->getName();
        $employee->delete();
        return redirect()->action('EmployeeController@index')->with('message', 'Employee ' . $name. ' deleted!');
    }

    /**
     * @param Employee $employee
     * @return array
     */
    protected function getFormData($employee = null)
    {
        $employee = $employee ? $employee : new Employee();
        $dateConfig = config('appSettings.date');
        $dateFormat = $dateConfig['phpFormat'];
        $dateOfBirthEndDate = strtotime($dateConfig['dateOfBirthEndDate']);
        $dateOfEmploymentEndDate = strtotime($dateConfig['dateOfEmploymentEndDate']);

        return [
            'employee' => $employee,
            'employees' => $this->getValidSupervisors($employee),
            'departments' => Department::orderBy('path')->get(),
            'positions' => Position::orderBy('path')->get(),
            'genderOptions' => $employee->getGenderOptions(true),
            'maritalStatusOptions' => $employee->getMaritalStatusOptions(true),

            'dateFormat' => $dateConfig['jsFormat'],
            'dateOfBirthEndDate' => $dateOfBirthEndDate ? date($dateFormat, $dateOfBirthEndDate) : '0d',
            'dateOfEmploymentEndDate' => $dateOfEmploymentEndDate ? date($dateFormat, $dateOfEmploymentEndDate) : '',

            'selectedSupervisor' => old('supervisor_id', $employee->supervisor_id),
            'selectedDepartment' => old('department_id', $employee->department_id),
            'selectedPosition' => old('position_id', $employee->position_id),
            'selectedGender' => old('gender', $employee->gender),
            'selectedMaritalStatus' => old('marital_status', $employee->marital_status),

        ];
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function validateForm($request) {
        $dateFormat = config('appSettings.date.phpFormat');
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'date_of_birth' => 'required|dateformat:' . $dateFormat,
            'date_of_employment' => 'required|dateformat:' . $dateFormat,
        );
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Employee $employee
     */
    protected function setData(&$employee)
    {
        $employee->first_name = request('first_name');
        $employee->last_name = request('last_name');
        $employee->gender = request('gender');
        $employee->phone = request('phone');
        $employee->email = request('email');
        $employee->address = request('address');
        $employee->marital_status = request('marital_status');

        $supervisorId = (int)request('supervisor_id');
        if ($supervisorId) {
            $employee->supervisor_id = $supervisorId;
        } else {
            $employee->supervisor_id = null;
        }

        $departmentId = (int)request('department_id');
        if ($departmentId) {
            $employee->department_id = $departmentId;
        } else {
            $employee->department_id = null;
        }

        $positionId = (int)request('position_id');
        if ($positionId) {
            $employee->position_id = $positionId;
        } else {
            $employee->position_id = null;
        }

        $dateFormat = config('appSettings.date.phpFormat');
        $dateOfBirth = request('date_of_birth');
        if ($dateOfBirth) {
            $employee->date_of_birth = \DateTime::createFromFormat($dateFormat, $dateOfBirth);
        }

        $dateOfEmployment = request('date_of_employment');
        if ($dateOfEmployment) {
            $employee->date_of_employment = \DateTime::createFromFormat($dateFormat, $dateOfEmployment);
        }
    }

    /**
     * @param Employee $employee
     * @return array
     */
    protected function getValidSupervisors($employee = null)
    {
        $query = Employee::query()->orderBy('first_name')->orderBy('last_name');
        if (is_object($employee) && $employeeId = (int)$employee->id) {
            $query->whereKeyNot($employeeId);
            $query->where(function ($supervisorQuery) use ($employeeId) {
                $supervisorQuery->where('supervisor_id', '!=', $employeeId)
                    ->orWhereNull('supervisor_id');
            });
        }
        return $query->get();
    }
}
