<?php
//STARTING TH SEASION
session_start();

//CHECKING IF THE RECEIVED DATA IS SET PROPERLY
if(isset($_GET["acc_type"])){
    //IF THE DATA IS RECEIVED PROPERLY
    $acc_type = $_GET["acc_type"];

    if($acc_type == 1){
        //IF ACCOUNT TYPE IS STUDENT
        unset($_SESSION["student"]);

    }else if($acc_type == 2){
        //IF ACCOUNT TYPE IS TEACHER
        unset($_SESSION["teacher"]);

    }else if($acc_type == 3){
        //IF ACCOUNT TYPE IS ACADEMIC OFFICER
        unset($_SESSION["officer"]);

    }else if ($acc_type == 4){
        //IF ACCOUNT TYPE IS ADMIN
        unset($_SESSION["admin"]);

    }else{
        //IF NO MATCH, FULL SESSION IS DESTROYED
        session_destroy();

    }

    echo("success");

}else {
    //IF THE DATA IS NOT RECEIVED PROPERLY
    session_destroy();
    echo("success");

}

?>