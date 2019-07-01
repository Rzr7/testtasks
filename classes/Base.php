<?php

class Base
{
    /**
    * Night Time Start
    * @var DateTime
    */
    private $nightTimeStart;

    /**
    * Night Time End
    * @var DateTime
    */
    private $nightTimeEnd;

    /**
    * List of Employees
    * @var Array
    */
    private $employees;

    /**
    * Class constructor
    * @param Array $employees Employees from predefined array.
    * @param String $nightStart Night Time Start from predefined options.
    * @param String $nightEnd Night Time End from predefined options.
    */
    function __construct($employees, $nightStart, $nightEnd) {
        // Create DateTime objects from time strings.
        $this->nightTimeStart = DateTime::createFromFormat("H:i", $nightStart);
        $this->nightTimeEnd = DateTime::createFromFormat("H:i", $nightEnd);

        // Check if "End" string is smaller than "Start", if so - it's next day.
        if ($this->nightTimeEnd < $this->nightTimeStart) {
            $this->nightTimeEnd->add(new DateInterval('P1D'));
        }

        // Create employees objects and add to array;
        $this->employees = array();
        foreach ($employees as $employee) {
            $newEmployee = $this->createEmployee($employee);
            $this->employees[] = $newEmployee;
        }
    }

    /**
    * Create employee object from data.
    * @param Array $employeeArray Array of Employee data.
    * @return Employee Employee object.
    */
    private function createEmployee($employeeArray) {
        $employeeArray['night_start'] = $this->nightTimeStart;
        $employeeArray['night_end'] = $this->nightTimeEnd;
        $employee = new Employee($employeeArray);
        return $employee;
    }

    /**
    * Get array of employees.
    * @return Array Employees list.
    */
    public function getEmployees() {
        return $this->employees;
    }

    /**
    * Get Night Time Start object.
    * @return DateTime Night Time Start.
    */
    public function getNightTimeStart() {
        return $this->nightTimeStart;
    }

    /**
    * Get Night Time End object.
    * @return DateTime Night Time End.
    */
    public function getNightTimeEnd() {
        return $this->nightTimeEnd;
    }

    /**
    * Return generated html to display in browser
    * @return String HTML of employees with calculated data.
    */
    public function generateEmployeesList() {
        $html = '<b>Night Time Start:</b> ' . $this->nightTimeStart->format('H:i') . '<br>';
        $html .= '<b>Night Time End:</b> ' . $this->nightTimeEnd->format('H:i') . '<br>';
        $html .= '<br>';
        foreach ($this->employees as $employee) {
            $html .= '<b>Name:</b> ' . $employee->getName() . '<br>';
            $html .= '<b>Shift Start:</b> ' . $employee->getShiftStart() . '<br>';
            $html .= '<b>Shift End:</b> ' . $employee->getShiftEnd() . '<br>';
            $html .= '<b>Shift Duration:</b> ' . $employee->getDuration() . '<br>';
            $html .= '<b>Day Time:</b> ' . $employee->getDayTime() . '<br>';
            $html .= '<b>Night Time:</b> ' . $employee->getNightTime() . '<br>';
            $html .= '<br>';
        }
        return $html;
    }
}