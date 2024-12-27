<?php
//STARTING SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["subject"]) && isset($_GET["title"]) && isset($_GET["grade"])){
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $teacher_id = $_SESSION["teacher"]["teacher_id"];
    $subject = $_GET["subject"];
    $title = $_GET["title"];
    $grade = $_GET["grade"];
    //END STORING DATA

    //START CUSTOM QUERY CODE
    $query = "SELECT `answer_id`,`answers`.`path` AS answerPath,`student_student_id`,`assignment_assignment_id`,`answers`.`datetime` AS answerDateTime,
    `assignments`.`datetime`,`assignment_id`,`title`,`assignments`.`teacher_has_subject_id`,`teacher_has_subject`.`teacher_has_subject_id`,`teacher_teacher_id`,`subject_subject_id`,`teacher_has_subject`.`grade` AS stugrade,
    `subject_id`,`subject_name`,`student_id`,`initials`,`first_name`,`last_name`,`mobile` FROM `answers` 
    INNER JOIN `assignments` ON `answers`.`assignment_assignment_id` = `assignments`.`assignment_id` 
    INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `assignments`.`teacher_has_subject_id` 
    INNER JOIN `subject` ON `subject`.`subject_id` = `teacher_has_subject`.`subject_subject_id` 
    INNER JOIN `student` ON `student`.`student_id` = `answers`.`student_student_id` 
    WHERE `teacher_teacher_id` = '" . $teacher_id . "'";

    if ($subject != 0) {
        //IF THE SUBJECT IS SELECTED
        $query .= " AND `subject_subject_id` = '" . $subject . "'";
    }

    if ($grade >= 1 && $grade <= 13) {
        //IF THE GRADE IS SELECTED
        $query .= " AND `stugrade` = '" . $grade . "'";
    }

    if(!empty($title)){
        //IF A TITLE IS INSERTED
        $query.=" AND `title` LIKE '%".$title."%'";
    }
    //ORDERING THE QUERY BY DATETIME DESCENDING
    $query.=" ORDER BY `datetime` DESC";
    //END OF CUSTOM QUERY CODE

    $answer_rs = Database::search($query);
    $answer_num = $answer_rs->num_rows;

    if ($answer_num > 0) {
        //IF RESULTS ARE AVAILABLE

        //LOOPING THROUGH THE RESULTS
        for ($x = 0; $x < $answer_num; $x++) {
            $answer_data = $answer_rs->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> Assignment : <?php echo ($answer_data["title"]); ?> (ID : <?php echo ($answer_data["answer_id"]); ?>)</p>
                                <div class="description"><?php echo ($answer_data["subject_name"]); ?> (Uploaded <?php echo ($answer_data["answerDateTime"]); ?>)</div>
                                <div class="description"><?php echo ($answer_data["initials"]." ".$answer_data["first_name"]." ".$answer_data["last_name"]); ?> (Student ID : <?php echo ($answer_data["student_id"]); ?>)(Mobile : <?php echo ($answer_data["mobile"]); ?>) (Grade : <?php echo ($answer_data["stugrade"]); ?>)</div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered six wide column grid file_item_action">
                        <div class="ui celled horizontal list">
                            <div class="item">
                                <a href="downloadPDF.php?file=<?php echo($answer_data["answerPath"]) ?>"><i class="download icon"></i> Download</a>
                            </div>
                            <div class="item">
                                <a href="<?php echo($answer_data["answerPath"]) ?>"><i class="eye icon"></i> View</a>
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
    //IF DATA IS NOT RECEIVED PROPERLY
    echo("1");
}
