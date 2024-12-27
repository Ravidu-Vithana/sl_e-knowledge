<?php
//STARTING SESSION
session_start();
//REQUIRING DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["subject"]) && isset($_GET["title"]) && isset($_GET["grade"])){
    //IF THE DATA ARE PROPERLY RECEIVED

    //START STORING DATA
    $teacher_id = $_SESSION["teacher"]["teacher_id"];
    $subject = $_GET["subject"];
    $title = $_GET["title"];
    $grade = $_GET["grade"];
    //END OF STORING DATA

    //START CUSTOM QUERY CODE
    $query = "SELECT `mark_id`,`mark`,`student_student_id`,`assignment_assignment_id`,`release`,`marks`.`datetime` AS marksDateTime,
    `assignments`.`datetime`,`assignment_id`,`title`,`assignments`.`teacher_has_subject_id`,`teacher_has_subject`.`teacher_has_subject_id`,`teacher_teacher_id`,`subject_subject_id`,
    `subject_id`,`subject_name`,`student_id`,`initials`,`first_name`,`last_name`,`mobile` FROM `marks` 
    INNER JOIN `assignments` ON `marks`.`assignment_assignment_id` = `assignments`.`assignment_id` 
    INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `assignments`.`teacher_has_subject_id` 
    INNER JOIN `subject` ON `subject`.`subject_id` = `teacher_has_subject`.`subject_subject_id` 
    INNER JOIN `student` ON `student`.`student_id` = `marks`.`student_student_id` 
    WHERE `teacher_teacher_id` = '" . $teacher_id . "'";

    if ($subject != 0) {
        //IF THE SUBJECT IS SELECTED
        $query .= " AND `subject_subject_id` = '" . $subject . "'";
    }

    if ($grade >= 1 && $grade <= 13) {
        //IF THE GRADE IS SELECTED
        $query .= " AND `marks`.`grade` = '" . $grade . "'";
    }

    if(!empty($title)){
        //IF A NAME IS INSERTED
        $query.=" AND (`title` LIKE '%".$title."%' OR `initials` LIKE '".$title."%' OR `first_name` LIKE '".$title."%' OR `last_name` LIKE '".$title."%')";
    }
    //ORDER THE RESULTS BY DATETIME DESCENDING
    $query.=" ORDER BY `datetime` DESC";
    //END OF CUSTOM QUERY CODE

    $mark_rs = Database::search($query);
    $mark_num = $mark_rs->num_rows;

    if ($mark_num > 0) {
        //IF RESULTS ARE AVAILABLE

        //LOOPING THROUGH RESULTS
        for ($x = 0; $x < $mark_num; $x++) {
            $mark_data = $mark_rs->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> <?php echo ($mark_data["initials"]." ".$mark_data["first_name"]." ".$mark_data["last_name"]); ?> (Student ID : <?php echo ($mark_data["student_id"]); ?>) Marks : <?php echo ($mark_data["mark"]); ?></p>
                                <div class="description">Assignment : <?php echo ($mark_data["title"]); ?> (ID : <?php echo ($mark_data["mark_id"]); ?>)</div>
                                <div class="description"><?php echo ($mark_data["subject_name"]); ?> (Uploaded <?php echo ($mark_data["marksDateTime"]); ?>)</div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered six wide column grid file_item_action">
                        <div class="ui celled horizontal list">
                            <div class="item">
                                <a onclick="deleteMarks('<?php echo ($mark_data['mark_id']); ?>')"><i class="trash icon"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    } else {
        //IF NO RESULTS AVAILABLE
        ?>

        <!-- empty view -->
        <img src="resources/nothing.jpg" class="ui centered medium image">
        <div class="ui centered grid column">
            <p class="nothingText">Nothing yet...!</p>
        </div>
        <!-- empty view -->
<?php

    }

}else{
    //IF DATA ARE NOT RECEIVED PROPERLY
    echo("1");
}
