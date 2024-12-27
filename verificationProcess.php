<?php

session_start();
require "connection.php";

if (isset($_GET["vcode"]) && isset($_GET["acc_type"])) {

    $vcode = $_GET["vcode"];
    $acc_type = $_GET["acc_type"];

    if (empty($vcode)) {
        echo ("Please enter the provided verification code");
    } else {

        if ($acc_type == 1) {

            if (isset($_SESSION["vStudent"]["uname"]) && isset($_SESSION["vStudent"]["password"])) {
                $uname = $_SESSION["vStudent"]["uname"];
                $password = $_SESSION["vStudent"]["password"];

                $student_rs = Database::search("SELECT * FROM `student` WHERE `username` = '" . $uname . "' 
                AND `password` = '" . $password . "'");

                $student_data = $student_rs->fetch_assoc();

                if($student_data["status"] == 1){
                    if ($vcode == $student_data["verification_code"]) {

                        $_SESSION["student"] = $student_data;
    
                        $new_code = uniqid();
    
                        Database::iud("UPDATE `student` SET `verification_code` = '" . $new_code . "',`verified` = '1' WHERE `username` = '" . $uname . "' 
                        AND `password` = '" . $password . "'");
    
                        echo ("success");
                    } else {
                        echo ("Invalid Verification Code");
                    }
                }else{
                    echo("You have been blocked by the admin. Please contact your academic officer.");
                }

            } else {
                echo ("1");
            }
        } else if ($acc_type == 2) {

            if (isset($_SESSION["vTeacher"]["uname"]) && isset($_SESSION["vTeacher"]["password"])) {
                $uname = $_SESSION["vTeacher"]["uname"];
                $password = $_SESSION["vTeacher"]["password"];

                $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `username` = '" . $uname . "' 
            AND `password` = '" . $password . "'");

                $teacher_data = $teacher_rs->fetch_assoc();

                if ($vcode == $teacher_data["verification_code"]) {

                    $_SESSION["teacher"] = $teacher_data;

                    $new_code = uniqid();

                    Database::iud("UPDATE `teacher` SET `verification_code` = '" . $new_code . "',`verified` = '1' WHERE `username` = '" . $uname . "' 
                AND `password` = '" . $password . "'");

                    echo ("success");
                } else {
                    echo ("Invalid Verification Code");
                }
            } else {
                echo ("1");
            }
        } else if ($acc_type == 3) {

            if (isset($_SESSION["vOfficer"]["uname"]) && isset($_SESSION["vOfficer"]["password"])) {
                $uname = $_SESSION["vOfficer"]["uname"];
                $password = $_SESSION["vOfficer"]["password"];

                $academic_officer_rs = Database::search("SELECT * FROM `academic_officer` WHERE `username` = '" . $uname . "' 
            AND `password` = '" . $password . "'");

                $academic_officer_data = $academic_officer_rs->fetch_assoc();

                if ($vcode == $academic_officer_data["verification_code"]) {

                    $_SESSION["academic_officer"] = $academic_officer_data;

                    $new_code = uniqid();

                    Database::iud("UPDATE `academic_officer` SET `verification_code` = '" . $new_code . "' WHERE `username` = '" . $uname . "' 
                AND `password` = '" . $password . "'");

                    Database::iud("UPDATE `academic_officer` SET `verified` = '1' WHERE `username` = '" . $uname . "' 
                AND `password` = '" . $password . "'");

                    echo ("success");
                } else {
                    echo ("Invalid Verification Code");
                }
            } else {
                echo ("1");
            }
        } else {
            echo ("1");
        }
    }
} else {
    echo ("1");
}
