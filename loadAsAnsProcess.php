<?php
//STARTING SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING WHETHER THE DATA ARE RECEIVED PROPERLY
if (isset($_GET["subject"])) {
    //IF THE DATA ARE RECEIVED PEOPERLY

    //START STORING DATA
    $subject = $_GET["subject"];
    $student_grade = $_SESSION["student"]["grade"];
    //END STORING DATA

    //IF THE SUBJECT IS NOT SELECTED
    if ($subject == 0) {

?>

        <option value="0">Select subject first</option>

        <?php

    } else {
        //IF THE SUBJECT IS SELECTED
        
        //SELECTING ALL ASSIGNMENTS RELATED TO THAT STUDENT'S GRADE AND THE SELECTED SUBJECT
        $assignment_rs = Database::search("SELECT * FROM `assignments` 
        INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `assignments`.`teacher_has_subject_id` 
        WHERE `subject_subject_id` = '" . $subject . "' AND `grade` = '" . $student_grade . "'");
        $assignment_num = $assignment_rs->num_rows;

        if ($assignment_num > 0) {
            //IF ASSIGNMENTS ARE AVAILABLE

            //LOOPING THROUGH ALL THE AVAILABLE ASSIGNMENTS
            for ($x = 0; $x < $assignment_num; $x++) {
                $assignment_data = $assignment_rs->fetch_assoc();
        ?>

                <option value="<?php echo ($assignment_data["assignment_id"]); ?>"><?php echo ($assignment_data["title"] . " (Assignment ID = " . $assignment_data["assignment_id"] . ")"); ?></option>

            <?php
            }
        } else {
            //IF NO ASSIGNMENTS ARE AVAILABLE

            ?>

            <option value="0">None</option>

    <?php

        }
    }
} else {
    //IF NO SUBJECT DATA IS RECEIVED
    ?>

    <option value="0">Select subject first</option>

<?php
}

?>