<?php
require_once "tooaeg.php";
require_once "classes/Base.php";
require_once "classes/Employee.php";

$base = new Base($EMPLOYEES, $SETTINGS_nighttime_start, $SETTINGS_nighttime_end);
echo $base->generateEmployeesList();
