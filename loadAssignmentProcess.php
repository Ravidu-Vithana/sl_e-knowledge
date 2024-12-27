<?php
//STARTING THE SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE  RECEIVED PROPERLY
if(isset($_GET["grade"])){
    //IF THE DATA ARE RECEIVED ROPERLY

    //START STORING DATA
    $grade = $_GET["grade"];
    $teacher_id = $_SESSION["teacher"]["teacher_id"];
    //END STORING DATA
    
    if($grade != 0){
        //IF THE GRADE IS SELECTED

        //SELECTING ALL ASSIGNMENTS RELATED TO THAT GRADE
        $assignment_rs = Database::search("SELECT * FROM `assignments` 
        INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `assignments`.`teacher_has_subject_id`
        WHERE `grade` = '".$grade."' AND `teacher_teacher_id` = '".$teacher_id."'");
        $assignment_num = $assignment_rs->num_rows;

        if($assignment_num > 0){
            //IF ASSIGNMENTS ARE AVAILABLE
            ?>
        
            <option value="0">-Select-</option>
    
            <?php
        
            //LOOPING THROUGH AVAILABLE ASSIGNMENTS
            for($x = 0; $x < $assignment_num; $x++){
        
                $assignment_data = $assignment_rs->fetch_assoc();
        
                ?>
                
                <option value="<?php echo($assignment_data["assignment_id"]); ?>"><?php echo($assignment_data["title"]); ?> (Assignment ID - <?php echo($assignment_data["assignment_id"]); ?>)</option>
                
                <?php
        
            }
        }else{
            //IF NO ASSIGNMENTS ARE AVAILABLE
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