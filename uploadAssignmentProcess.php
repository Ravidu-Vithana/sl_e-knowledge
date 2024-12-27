<?php

session_start();
require "connection.php";

if(isset($_POST["title"]) && isset($_POST["grade"]) && isset($_POST["subject"])){

    $title = $_POST["title"];
    $grade = $_POST["grade"];
    $subject = $_POST["subject"];
    $teacher_id = $_SESSION["teacher"]["teacher_id"];

    $assignment_title_rs = Database::search("SELECT * FROM `assignments` WHERE `title` = '".$title."'");
    $assignment_title_num = $assignment_title_rs->num_rows;

    if(empty($title)){
        echo("Please insert the title.");
    }else if(strlen($title) > 150){
        echo("Title cannot exceed more than 150 characters.");
    }else if($assignment_title_num != 0){
        echo("This assignment title has already been used.");
    }else if($grade == 0){
        echo("Please select the grade.");
    }else if($subject == 0){
        echo("Please select the subject.");
    }else{
        $length = sizeof($_FILES);

        if($length == 0){
            echo("Please upload the Assignment.");
        }else if ($length == 1){

            $allowed_extensions = array("application/pdf");

            if(isset($_FILES["file"])){

                $file = $_FILES["file"];
                $file_extension = $file["type"];

                if(in_array($file_extension,$allowed_extensions)){

                    $subject_rs = Database::search("SELECT * FROM `subject` WHERE `subject_id` = '".$subject."'");
                    $subject_data = $subject_rs->fetch_assoc();

                    $teacher_has_subject_rs = Database::search("SELECT * FROM `teacher_has_subject` WHERE `teacher_teacher_id` = '".$teacher_id."' 
                    AND `subject_subject_id` = '".$subject."' AND `grade` = '".$grade."'");

                    if($teacher_has_subject_rs->num_rows == 1){

                        $d = new DateTime();
                        $tz = new DateTimeZone("Asia/Colombo");
                        $d->setTimezone($tz);
                        $date = $d->format("Y-m-d H:i:s");

                        $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();
                    
                        $file_name = "resources//assignments//as_".uniqid()."_g".$grade."_".$subject_data["subject_name"].".pdf";
                        move_uploaded_file($file["tmp_name"],$file_name);
    
                        Database::iud("INSERT INTO `assignments`(`title`,`path`,`teacher_has_subject_id`,`datetime`) 
                        VALUES('".$title."','".$file_name."','".$teacher_has_subject_data["teacher_has_subject_id"]."','".$date."')");
    
                        echo("success");

                    }else{
                        echo("1");
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