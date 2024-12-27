<?php

require "connection.php";

if(isset($_POST["marks"]) && isset($_POST["grade"]) && isset($_POST["student"]) && isset($_POST["assignment"])){

    $marks = $_POST["marks"];
    $grade = $_POST["grade"];
    $student = $_POST["student"];
    $assignment = $_POST["assignment"];

    if(empty($marks)){
        echo("Please enter the marks.");
    }else if(!is_numeric($marks)){
        echo("Invalid Marks!");
    }else if($grade == 0){
        echo("Please select the grade.");
    }else if($student == 0){
        echo("Please select the student.");
    }else if ($assignment == 0){
        echo("Please select the assignment.");
    }else {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
        
        Database::iud("INSERT INTO `marks` (`mark`,`assignment_assignment_id`,`student_student_id`,`datetime`,`grade`) 
        VALUES('".$marks."','".$assignment."','".$student."','".$date."','".$grade."')");
        echo("success");

    }

}else {
    echo("1");
}

?>