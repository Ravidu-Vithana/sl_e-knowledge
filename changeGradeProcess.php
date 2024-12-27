<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE RECEIVING DATA IS SET
if (isset($_GET["id"]) && isset($_GET["new"])) {
    //IF THE DATA IS RECEIVED PROPERLY

    //START STORING DATA
    $id = $_GET["id"];
    $new = $_GET["new"];
    //END STORING DATA

    //UPDATING THE NEW GRADE OF THE RELEVANT STUDENT
    Database::iud("UPDATE `student` SET `grade` = '".$new."',`enrollment_fee_status` = '0' WHERE `student_id` = '".$id."'");
    echo("success");
    
} else {
    //IF THE DATA IS NOT RECEIVED PROPERLY
    echo ("1");
}
