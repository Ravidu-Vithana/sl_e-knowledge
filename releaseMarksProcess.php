<?php
//REQUIRE DATABASE CONNECTION
require "connection.php";

//CEHCKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["id"])){
    //IF DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $id = $_GET["id"];
    //END OF STORING DATA

    if($id == "all"){
        //IF ALL MARKS SHOULD BE RELEASED
        Database::iud("UPDATE `marks` SET `release` = '1' WHERE `release` = '0'");
        echo("success");
    }else{
        //IF THE MARKS RELEVANT TO THE SENT ID IS RELEASED
        Database::iud("UPDATE `marks` SET `release` = '1' WHERE `mark_id` = '".$id."'");
        echo("success");
    }

}else{
    //IF THE DATA IS NOT RECEIVED PROPERLY
    echo("1");
}

?>