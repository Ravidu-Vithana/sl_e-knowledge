<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["grade"])){
    //IF THE DATA IS RECEIVED PROPERLY

    //START STORING DATA
    $grade = $_GET["grade"];
    //END STORING DATA

    if($grade != 0){
        //IF GRADE ID SELECTED

        //SELECTING STUDENT ACCORDING TO THE GRADE
        $student_rs = Database::search("SELECT * FROM `student` WHERE `grade` = '".$grade."'");
        $student_num = $student_rs->num_rows;

        if($student_num > 0){
            //IF RESULTS ARE AVAILABLE
            ?>
        
            <option value="0">-Select-</option>
    
            <?php
            //LOOPING THROUGH THE RESULTS
            for($x = 0; $x < $student_num; $x++){
        
                $student_data = $student_rs->fetch_assoc();
        
                ?>
                
                <option value="<?php echo($student_data["student_id"]); ?>"><?php echo($student_data["first_name"]." ".$student_data["last_name"]); ?> (Student ID - <?php echo($student_data["student_id"]); ?>)</option>
                
                <?php
        
            }

        }else{
            //IF NO RESULTS AVAILABLE
            ?>
        
            <option value="0">None</option>
    
            <?php
        }

    }else {
        //IF THE GRADE IS NOT SELECTED
        ?>
        
        <option value="0">Select Grade First</option>

        <?php
    }

}else {
    //IF THE GRADE DATA IS NOT RECEIVED PROPERLY
    ?>
        
        <option value="0">Select Grade First</option>

    <?php

}

?>