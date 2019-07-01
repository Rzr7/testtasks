<?php

class Employee
{
    /**
    * Name of employee
    * @var String
    */
    private $name;

    /**
    * Start of shift
    * @var DateTime
    */
    private $shiftStart;

    /**
    * End of shift
    * @var DateTime
    */
    private $shiftEnd;

    /**
    * Total duration of Employee shift
    * @var DateTime
    */
    private $duration;

    /**
    * Duration of shift while was Day time
    * @var DateTime
    */
    private $dayTime;

    /**
    * Duration of shift while was Night time
    * @var DateTime
    */
    private $nightTime;

    /**
    * Night time start
    * @var DateTime
    */
    private $nightStart;

    /**
    * Night time end
    * @var DateTime
    */
    private $nightEnd;

    /**
    * Class constructor
    * @param Array $employee Employee data.
    */
    function __construct($employee) {
        $this->name = $employee['name'];
        $this->shiftStart = DateTime::createFromFormat("H:i", $employee['shift_start']);
        $this->shiftEnd = DateTime::createFromFormat("H:i", $employee['shift_end']);
        $this->nightStart = $employee['night_start'];
        $this->nightEnd = $employee['night_end'];

        // Check if "End" time is smaller than "Start", if so - it's next day.
        if ($this->shiftEnd < $this->shiftStart) {
            $this->shiftEnd->add(new DateInterval('P1D'));
        }

        // Calculate duration of shift.
        $this->duration = $this->shiftStart->diff($this->shiftEnd);
        $this->duration = DateTime::createFromFormat("H:i", $this->duration->format("%H") . ':' . $this->duration->format("%I"));

        // Finally calculate day and night shift durations.
        $this->calculateDayNightTime();
    }

    /**
    * Get employee name.
    * @return String Employee name.
    */
    public function getName() {
        return $this->name;
    }

    /**
    * Get employee shift start.
    * @return String Employee formatted shift start.
    */
    public function getShiftStart() {
        return $this->shiftStart->format('H:i');
    }

    /**
    * Get employee shift end.
    * @return String Employee formatted shift end.
    */
    public function getShiftEnd() {
        return $this->shiftEnd->format('H:i');
    }
    
    /**
    * Get employee shift duration.
    * @return String Employee formatted shift duration.
    */
    public function getDuration() {
        return $this->duration->format("H:i");
    }

    /**
    * Get employee day time shift duration.
    * @return String Employee formatted day time shift duration.
    */
    public function getDayTime() {
        if ($this->dayTime) {
            return $this->dayTime->format("H:i");
        }
        return '00:00';
    }

    /**
    * Get employee night time shift duration.
    * @return String Employee formatted night time shift duration.
    */
    public function getNightTime() {
        if ($this->nightTime) {
            return $this->nightTime->format("H:i");
        }
        return '00:00';
    }

    /**
    * Calculate day and night shift times.
    * @return void.
    */
    private function calculateDayNightTime() {
        // Time at night.
        $overLapDiffNight = false;
        // Time before night.
        $overLapDiffDay = false;
        // Time after night.
        $overLapDiffDay2 = false;
    
        // Shift is at night time.
        if ($this->shiftStart >= $this->nightStart && $this->shiftEnd <= $this->nightEnd) {
            $this->nightTime = $this->duration;
        // Shift is partially at night time.
        } else if ($this->shiftEnd > $this->nightStart && $shiftStart < $this->nightEnd) {
            // Shift Start is before night time.
            if ($this->shiftStart < $this->nightStart) {
                $overLapDiffDay = $this->shiftStart->diff($this->nightStart);
            }

            // Shift End is after night time.
            if ($this->shiftEnd > $this->nightEnd) {
                $overLapDiffDay2 = $this->shiftEnd->diff($this->nightEnd);
            }

            // Shift End is between night time.
            if ($this->shiftEnd < $this->nightEnd) {
                $overLapDiffNight = $this->nightStart->diff($this->shiftEnd);
            // Shift Start is between night time.
            } else if ($this->shiftStart > $this->nightStart) {
                $overLapDiffNight = $this->shiftStart->diff($this->nightEnd);
            // Otherwise.
            } else {
                $overLapDiffNight = $this->nightStart->diff($this->nightEnd);
            }
            
            // Shift start and End is not between Night time.
            if ($overLapDiffDay || $overLapDiffDay2) {
                $overLapHours = $overLapDiffDay->h + $overLapDiffDay2->h;
                $overLapHours = new DateInterval('PT' . $overLapHours . 'H');
                $overLapMinutes = $overLapDiffDay->i + $overLapDiffDay2->i;
                $overLapMinutes = new DateInterval('PT' . $overLapMinutes . 'M');
                $this->dayTime = DateTime::createFromFormat("H:i", $overLapHours->format("%H") . ':' . $overLapMinutes->format("%I"));
            }

            if ($overLapDiffNight) {
                $this->nightTime = DateTime::createFromFormat("H:i", $overLapDiffNight->format("%H") . ':' . $overLapDiffNight->format("%I"));
            }
        // Shift is at day time.
        } else {
            $this->dayTime = $this->duration;
        }
    }
}