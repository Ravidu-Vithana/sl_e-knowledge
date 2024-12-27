<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_POST["vcode"]) && isset($_POST["newpw"]) && isset($_POST["conpw"]) && isset($_POST["email"]) && isset($_POST["acc_type"])) {
    //IF THE DATA IS RECEIVED PROPERLY

    //START STORING DATA
    $vcode = $_POST["vcode"];
    $newPw = $_POST["newpw"];
    $conPw = $_POST["conpw"];
    $email = $_POST["email"];
    $acc_type = $_POST["acc_type"];
    //END OF STORING DATA

    //START OF VALIDATION
    if (empty($vcode)) {
        echo ("Please enter the verification code.");
    } else if (empty($newPw)) {
        echo ("Please enter the new password.");
    } else if (strlen($newPw) < 5 || strlen($conPw) > 20) {
        echo ("Password should have been 5 - 20 characters!");
    } else if (empty($conPw)) {
        echo ("Please confirm the new password.");
    } else if ($newPw != $conPw) {
        echo ("Passwords do not match!");
    } else {
        //END OF VALIDATION

        //CHECKING IN WHICH ACCOUNT THE PASSWORD IS RESETTED
        if ($acc_type == 1) {
            //IF THE ACCOUNT TYPE IS STUDENT

            //SEARCHING FOR A STUDENT WITH THIS EMAIL AND VERIFICATION CODE
            $student_rs = Database::search("SELECT * FROM `student` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "'");
            $student_num = $student_rs->num_rows;

            if ($student_num == 1) {
                //IF RESULTS AVAILABLE

                $student_data = $student_rs->fetch_assoc();

                if ($newPw == $student_data["password"]) {
                    //IF THE NEW PASSWORD EQUALS TO THE OLD PASSWORD

                    echo ("This password has already been used!");
                } else {

                    Database::iud("UPDATE `student` SET `password` = '" . $newPw . "' WHERE `email` = '" . $email . "'");
                    echo ("success");
                }
            } else {
                //IF THE EMAIL OR THE VERIFICATION CODE IS INVALID
                echo ("Invalid email or verification code");
            }
        } else if ($acc_type == 2) {
            //IF THE ACCOUNT TYPE IS TEACHER

            //SEARCHING FOR TEACHERS WITH THE RECEIVED EMAIL AND VERIFICATION CODE
            $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "'");
            $teacher_num = $teacher_rs->num_rows;

            if ($teacher_num == 1) {
                //IF A TEACHER IS AVAILABLE

                $teacher_data = $teacher_rs->fetch_assoc();

                if ($newPw == $teacher_data["password"]) {
                    //IF THE NEW PASSWORD IS SAME AS THE CURRENT PASSWORD
                    echo ("This password has already been used!");
                } else {

                    Database::iud("UPDATE `teacher` SET `password` = '" . $newPw . "' WHERE `email` = '" . $email . "'");
                    echo ("success");
                }
            } else {
                //IF THE EMAIL OR VERIFICATION CODE IS INVALID
                echo ("Invalid email or verification code");
            }
        } else if ($acc_type == 3) {
            //IF THE ACCOUNT TYPE IS ACADEMIC OFFICER

            //SEARCH FOR ACADEMIC OFFICERS WITH THE RECEIVED EMAIL AND VERIFICATION CODE
            $academic_officer_rs = Database::search("SELECT * FROM `academic_officer` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "'");
            $academic_officer_num = $academic_officer_rs->num_rows;

            if ($academic_officer_num == 1) {
                //IF RESULTS AVAILABLE
                $academic_officer_data = $academic_officer_rs->fetch_assoc();

                if ($newPw == $academic_officer_data["password"]) {
                    //IF THE NEW PASSWORD IS SAME AS THE CURRENT PASSWORD
                    echo ("This password has already been used!");
                } else {

                    Database::iud("UPDATE `academic_officer` SET `password` = '" . $newPw . "' WHERE `email` = '" . $email . "'");
                    echo ("success");
                }
            } else {
                //IF THE RECEIVED EMAIL OR VEROFOCATION CODE IS INVALID
                echo ("Invalid email or verification code");
            }
        } else if ($acc_type == 4) {
            //IF THE ACCOUNT TYPE IS ADMIN

            //SEARCHING FOR AN ADMIN WITH RECEIVED EMAIL AND VERIFICATION CODE
            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "'");
            $admin_num = $admin_rs->num_rows;

            if ($admin_num == 1) {
                //IF RESULTS AVAILABLE
                $admin_data = $admin_rs->fetch_assoc();

                if ($newPw == $admin_data["password"]) {
                    //IF THE NEW PASSWORD IS SAME AS THE CURRENT PASSWORD
                    echo ("This password has already been used!");
                } else {

                    Database::iud("UPDATE `admin` SET `password` = '" . $newPw . "' WHERE `email` = '" . $email . "'");
                    echo ("success");
                }
            } else {
                //IF THE RECEIVED EMAIL OR VERIFICATION CODE IS INVALID
                echo ("Invalid email or verification code");
            }
        }
    }
} else {
    //IF THE DATA IS NOT RECIEVED PROPERLY
    echo ("1");
}
