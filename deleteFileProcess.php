<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA IS RECEIVED PROPERLY
if(isset($_GET["id"]) && isset($_GET["type"])){
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $id = $_GET["id"];
    $type = $_GET["type"];
    //END STORING DATA

    //CHECKING THE FILE TYPE THAT IS DELETING
    if($type == "assignment"){
        //IF THE FILE TYPE IS ASSIGNMENT

        //DELETING ANSWERS AND MARKS RELATED TO THAT ASSIGNMENT
        Database::iud("DELETE FROM `answers` WHERE `assignment_assignment_id` = '".$id."'");
        Database::iud("DELETE FROM `marks` WHERE `assignment_assignment_id` = '".$id."'");

        //DELETING THE ASSIGNMENT
        Database::iud("DELETE FROM `assignments` WHERE `assignment_id` = '".$id."'");
        echo("success");
    }else if($type == "note"){
        //IF THE FILE TYPE IS NOTE

        //DELETING NOTE
        Database::iud("DELETE FROM `notes` WHERE `notes_id` = '".$id."'");
        echo("success");
    }else if($type == "answer"){
        //IF THE FILE TYPE IS ANSWER

        //DELETING ANSWER
        Database::iud("DELETE FROM `answers` WHERE `answer_id` = '".$id."'");
        echo("success");
    }else if ($type == "mark"){
        //IF THE ITEM IS MARKS

        //DELETING MARKS
        Database::iud("DELETE FROM `marks` WHERE `mark_id` = '".$id."'");
        echo("success");
    }else{
        //IF ANY OTHER TYPE IS RECEIVED, ERROR IS SENT BACK
        echo("1");
    }

}else{
    //IF DATA IS NOT RECEIVED PROPERLY
    echo("1");
}

?>