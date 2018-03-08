<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use RPSHRMS\Models\Employee;
use RPSHRMS\Models\Department;
use RPSHRMS\Models\Position;

class EmployeeTableSeeder extends Seeder {

    /**
     * @return void
     */
    public function run()
    {
        $config = config('appSeeder');
        $demoUsers = (int)$config['sampleData']['employee'];
        $maritalStatusOptions = array_keys(Employee::maritalStatusOptions());
        $departments = Department::doesntHave('departments')->pluck('id')->all();
        $positions = Position::doesntHave('positions')->pluck('id')->all();
        $faker = Faker::create();

        for ($i = 0; $i < $demoUsers; $i++) {
            $employee = new Employee();
            if ($i % 2) {
                $employee->first_name = $faker->firstNameMale;
                $employee->gender = Employee::GENDER_OPTION_MALE;
            } else {
                $employee->first_name = $faker->firstNameFemale;
                $employee->gender = Employee::GENDER_OPTION_FEMALE;
            }
            $employee->last_name = $faker->lastName;
            $employee->email = $faker->email;
            $employee->department_id = $faker->randomElement($departments);
            $employee->position_id = $faker->randomElement($positions);
            $employee->marital_status = $faker->randomElement($maritalStatusOptions);
            $employee->date_of_employment = $faker->dateTimeBetween('-10 years');
            $employee->date_of_birth = $faker->dateTime('-20 years');
            $employee->address = $faker->address;
            $employee->phone = $faker->phoneNumber;
            $employee->save();
        }
    }
}
