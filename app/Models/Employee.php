<?php

namespace RPSEMS\ModelS;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $title
 * @property string $gender
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $marital_status
 * @property \DateTime $date_of_birth
 * @property \DateTime $date_of_employment
 * @property int $supervisor_id
 * @property int $department_id
 * @property int $position_id
 */

class Employee extends Model
{
    const GENDER_OPTION_MALE = 'male';
    const GENDER_OPTION_FEMALE = 'female';
    const GENDER_OPTION_OTHER = 'other';
    const MARITAL_STATUS_SINGLE = 'single';
    const MARITAL_STATUS_MARRIED = 'married';
    const MARITAL_STATUS_DIVORCED = 'divorced';
    const MARITAL_STATUS_WIDOWED = 'widowed';
    const MARITAL_STATUS_OTHER = 'other';

    /**
     * Get Supervisor.
     */
    public function supervisor()
    {
        return $this->belongsTo('RPSEMS\Models\Employee', 'supervisor_id');
    }

    /**
     * Get the supervised employees.
     */
    public function supervises()
    {
        return $this->hasMany('RPSEMS\Models\Employee', 'supervisor_id');
    }

    /**
     * @return int
     */
    public function isSupervisor()
    {
        return $this->supervises()->count();
    }

    /**
     * Get Department.
     */
    public function department()
    {
        return $this->belongsTo('RPSEMS\Models\Department');
    }

    /**
     * Get Position.
     */
    public function position()
    {
        return $this->belongsTo('RPSEMS\Models\Position');
    }

    /**
     * @return string
     */
    public function getSupervisorName() {
        return $this->supervisor ? $this->supervisor->name : '';
    }

    /**
     * @return string
     */
    public function getDepartmentName() {
        return $this->department ? $this->department->name : '';
    }

    /**
     * @return string
     */
    public function getPositionName() {
        return $this->position ? $this->position->name : '';
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getGender() {
        $options = $this->getGenderOptions();
        if ($this->gender && isset($options[$this->gender])) {
            return $options[$this->gender];
        }
        return '';
    }

    /**
     * @return string
     */
    public function getMaritalStatus() {
        $options = $this->getMaritalStatusOptions();
        if ($this->marital_status && isset($options[$this->marital_status])) {
            return $options[$this->marital_status];
        }
        return '';
    }

    /**
     * @return array
     */
    static public function genderOptions()
    {
        $options = [
            self::GENDER_OPTION_MALE => 'Male',
            self::GENDER_OPTION_FEMALE => 'Female',
            self::GENDER_OPTION_OTHER => 'Other',
        ];

        return $options;
    }

    /**
     * @return array
     */
    static public function maritalStatusOptions()
    {
        $options = [
            self::MARITAL_STATUS_SINGLE => 'Single',
            self::MARITAL_STATUS_MARRIED => 'Married',
            self::MARITAL_STATUS_DIVORCED => 'Divorced',
            self::MARITAL_STATUS_WIDOWED => 'Widowed',
            self::MARITAL_STATUS_OTHER => 'Other',
        ];

        return $options;
    }

    /**
     * @param bool $prependOption
     * @param string $prependLabel
     *
     * @return array
     */
    public function getGenderOptions($prependOption = false, $prependLabel = '- Select - ')
    {
        $options = self::genderOptions();
        if ($prependOption) {
            $options = array_merge([0 => $prependLabel], $options);
        }
        return $options;
    }

    /**
     * @param bool $prependOption
     * @param string $prependLabel
     *
     * @return array
     */
    public function getMaritalStatusOptions($prependOption = false, $prependLabel = '- Select - ')
    {
        $options = self::maritalStatusOptions();
        if ($prependOption) {
            $options = array_merge([0 => $prependLabel], $options);
        }
        return $options;
    }

    /**
     * @return string
     */
    public function getDisplayDateOfBirth() {
        return $this->formatDate($this->date_of_birth);
    }

    /**
     * @return string
     */
    public function getDisplayDateOfEmployment() {
        return $this->formatDate($this->date_of_employment);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    protected function formatDate($date) {
        $format = 'Y-m-d';
        $displayFormat = config('appSettings.date.phpFormat');

        return $date ? \DateTime::createFromFormat($format, $date)->format($displayFormat) : '';
    }
}
