<?php
//STARTING SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_GET["grade"])) {
    //IF THE DATA RECEIVED PROPERLY

    //START STORING DATA
    $grade = $_GET["grade"];
    $teacher_id = $_SESSION["teacher"]["teacher_id"];
    //END OF STORING DATA

    if ($grade == 0) {
    //IF THE GRADE IS NOT SELECTED
?>

        <option value="0">Select Grade First</option>

    <?php

    } else {
        //IF THE GRADE IS SELECTED

        //LOAD ALL THE ASSIGNED SUBJECTS FOR TEACHER AND THE PARTICULAR GRADE
        $teacher_has_subject_rs = Database::search("SELECT * FROM `teacher_has_subject` WHERE `teacher_teacher_id` = '" . $teacher_id . "' 
        AND `grade` = '" . $grade . "'");
        $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

        if($teacher_has_subject_num > 0){
            //IF RESULTS AVAILABLE
            ?>

            <option value="0">-Select-</option>
    
            <?php
            //LOOPING THROUGH RESULTS
            for ($x = 0; $x < $teacher_has_subject_num; $x++) {
    
                $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();
    
                $subject_rs = Database::search("SELECT * FROM `subject` WHERE `subject_id` = '" . $teacher_has_subject_data["subject_subject_id"] . "'");
                $subject_data = $subject_rs->fetch_assoc();
    
            ?>
    
                <option value="<?php echo ($subject_data["subject_id"]); ?>"><?php echo ($subject_data["subject_name"]); ?></option>
    
        <?php
    
            }
        }else{
            //IF RESULTS NOT AVAILABLE
            ?>

            <option value="0">None</option>
        
        <?php
        }
    }
} else {
    //IF THE GRADE DATA IS NOT RECEIVED PROPERLY
    ?>

    <option value="0">Select Grade First</option>

<?php

}

?>