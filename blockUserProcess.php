<?php 
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE RECEIVING DATA ARE SET
if(isset($_GET["id"]) && isset($_GET["type"])){
    //IF RECEIVED DATA ARE SET

    //STARTING STORING DATA
    $id = $_GET["id"];
    $type = $_GET["type"];
    $new_status;
    //END STORING DATA

    //CHECKING THE TYPE OF ACCOUNT TO BE BLOCKED
    if($type == "student"){
        //IF THE ACCOUNT TYPE IS STUDENT

        //CHECKING WHETHER THE STUDENT IS ACTIVE OR INACTIVE
        $result = Database::search("SELECT * FROM `student` WHERE `student_id` = '".$id."'");
        $result_data = $result->fetch_assoc();

        if($result_data["status"] == 1){
            //IF THE STUDENT IS ACTIVE, STUDENT IS BLOCKED
            $new_status = 0;
        }else{
            //IF THE STUDENT IS INACTIVE, STUDENT IS UNBLOCKED
            $new_status = 1;
        }

        //UPDATING THE NEW STATUS IN THE DATABASE
        Database::iud("UPDATE `student` SET `status`= '".$new_status."' WHERE `student_id` = '".$id."'");
        echo("success");
    }else if($type == "teacher"){
        //IF THE ACCOUNT TYPE IS TEACHER

        //CHECKING WHETHER THE TEACHER IS ACTIVE OR INACTIVE
        $result = Database::search("SELECT * FROM `teacher` WHERE `teacher_id` = '".$id."'");
        $result_data = $result->fetch_assoc();

        if($result_data["status"] == 1){
            //IF THE TEACHER IS ACTIVE, TEACHER IS BLOCKED
            $new_status = 0;
        }else{
            //IF THE TEACHER IS INACTIVE, TEACHER IS UNBLOCKED
            $new_status = 1;
        }

        //UPDATING THE NEW STATUS IN THE DATABASE
        Database::iud("UPDATE `teacher` SET `status`= '".$new_status."' WHERE `teacher_id` = '".$id."'");
        echo("success");
    }else if($type == "officer"){
        //IF THE ACCOUNT TYPE IS ACADEMIC OFFICER

        //CHECKING WHETHER THE ACADEMIC OFFICER IS ACTIVE OR INACTIVE
        $result = Database::search("SELECT * FROM `academic_officer` WHERE `academic_officer_id` = '".$id."'");
        $result_data = $result->fetch_assoc();

        if($result_data["status"] == 1){
            //IF ACTIVE, ACADEMIC OFFICER IS BLOCKED
            $new_status = 0;
        }else{
            //IF INACTIVE, ACADEMIC OFFICER IS UNBLOCKED
            $new_status = 1;
        }

        //UPDATING THE NEW STATUS IN THE DATABASE
        Database::iud("UPDATE `academic_officer` SET `status`= '".$new_status."' WHERE `academic_officer_id` = '".$id."'");
        echo("success");
    }else{
        //IF ANYOTHER ACCOUNT TYPE IS RECEIVED, IT IS ALERTED AS AN ERROR
        echo("1");
    }
}

?>