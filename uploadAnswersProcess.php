<?php

session_start();
require "connection.php";

if(isset($_POST["assignment"])){

    $assignment = $_POST["assignment"];
    $student_id = $_SESSION["student"]["student_id"];
    $mark_rs = Database::search("SELECT * FROM `marks` WHERE `student_student_id` = '".$student_id."' AND `assignment_assignment_id` = '".$assignment."'");

    if($assignment == 0){
        echo("Please select the assignment.");
    }else if($mark_rs->num_rows != 0){
        echo("Marks for a previous answer sheet has been assigned! Please contact your academic officer.");
    }else{
        $length = sizeof($_FILES);

        if($length == 0){
            echo("Please upload the Answer Sheet.");
        }else if ($length == 1){

            $allowed_extensions = array("application/pdf");

            if(isset($_FILES["file"])){

                $file = $_FILES["file"];
                $file_extension = $file["type"];

                if(in_array($file_extension,$allowed_extensions)){

                    $student_rs = Database::search("SELECT * FROM `student` WHERE `student_id` = '".$student_id."'");
                    $student_data = $student_rs->fetch_assoc();
                    
                    $file_name = "resources//answersheets//ans_as".$assignment."_".$student_data["first_name"]."_stuid".$student_data["student_id"].".pdf";
                    move_uploaded_file($file["tmp_name"],$file_name);

                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $date = $d->format("Y-m-d H:i:s");

                    $search_rs = Database::search("SELECT * FROM `answers` WHERE `student_student_id` = '".$student_id."' AND `assignment_assignment_id` = '".$assignment."' ");
                    $search_num = $search_rs->num_rows;

                    if($search_num == 1){

                        Database::iud("UPDATE `answers` SET `path` = '".$file_name."',`student_student_id` = '".$student_id."'
                        ,`assignment_assignment_id` = '".$assignment."',`datetime` = '".$date."' WHERE `student_student_id` = '".$student_id."' AND `assignment_assignment_id` = '".$assignment."'");

                        echo("success2");

                    }else {

                        Database::iud("INSERT INTO `answers`(`path`,`student_student_id`,`assignment_assignment_id`,`datetime`) 
                        VALUES('".$file_name."','".$student_id."','".$assignment."','".$date."')");

                        echo("success");

                    }

                }else {
                    echo("Invalid file type!");
                }

            }else {
                echo("1");
            }

        }else {
            echo("Invalid File Count!");
        }
    }

}else {
    echo("1");
}

?>