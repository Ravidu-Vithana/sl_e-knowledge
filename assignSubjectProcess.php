<?php
//REQUIRING THE DATAVASE CONNECTION
require "connection.php";

//CHECKING IF THE RECEIVED DATA ARE SET
if(isset($_GET["id"]) && isset($_GET["grade"]) && isset($_GET["subject"])){

    //START STORING DATA
    $id = $_GET["id"];
    $grade = $_GET["grade"];
    $subject = $_GET["subject"];
    //END STORING DATA

    //CHECKING IF A TEACHER IS ALREADY ASSIGNED WITH THIS SUBJECT AND GRADE
    $results = Database::search("SELECT * FROM `teacher_has_subject` WHERE `subject_subject_id` = '".$subject."' && `grade` = '".$grade."'");

    if($results->num_rows > 0){
        //IF A TEACHER IS ALREADY ASSIGNED FOR THIS SUBJECT AND GRADE
        echo("2");
    }else{
        //IF A TEACHER IS NOT ALREADY ASSIGNED

        //INSERTING NEW ASSIGNING DATA TO THE DATABASE
        Database::iud("INSERT INTO `teacher_has_subject` (`teacher_teacher_id`,`subject_subject_id`,`grade`) 
        VALUES('".$id."','".$subject."','".$grade."')");
        echo("success");
    }

}else{
    //IF ANY PROBLEM OCCURS WITH RECEIVING DATA
    echo("1");
}

?>