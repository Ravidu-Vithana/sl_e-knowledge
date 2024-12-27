<?php
//STARTING THE SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_GET["subject"]) && isset($_GET["title"])) {
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $student_id = $_SESSION["student"]["student_id"];
    $subject = $_GET["subject"];
    $title = $_GET["title"];
    //END STORING DATA

    //START CUSTOM QUERY CODE
    $query = "SELECT `answer_id`,`answers`.`path` AS answerPath,`answers`.`student_student_id`,`answers`.`assignment_assignment_id`,`answers`.`datetime`,`assignment_id`,`title`,
    `assignments`.`teacher_has_subject_id`,`teacher_has_subject`.`teacher_has_subject_id`,`subject_subject_id`,`subject_id`,`subject_name`,`mark`,`release` FROM `answers` 
    INNER JOIN `assignments` ON `answers`.`assignment_assignment_id` = `assignments`.`assignment_id` 
    LEFT JOIN `marks` ON `marks`.`assignment_assignment_id` = `answers`.`assignment_assignment_id` AND `marks`.`student_student_id` = `answers`.`student_student_id` 
    INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `assignments`.`teacher_has_subject_id` 
    INNER JOIN `subject` ON `subject`.`subject_id` = `teacher_has_subject`.`subject_subject_id` 
    WHERE `answers`.`student_student_id` = '" . $student_id . "'";

    if ($subject != 0) {
        //IF SUBJECT IS SELECTED
        $query .= " AND `subject_subject_id` = '" . $subject . "'";
    }

    if (!empty($title)) {
        //IF THE TITLE IS TYPED
        $query .= " AND `title` LIKE '%" . $title . "%'";
    }
    //ORDERING THE RESULTS BY DATETIME DESCENDING
    $query .= " ORDER BY `answers`.`datetime` DESC";
    //END OF CUSTOM QUERY CODE

    $answer_rs = Database::search($query);
    $answer_num = $answer_rs->num_rows;

    if ($answer_num > 0) {
        //IF RESULTS ARE AVAILABLE

        //LOOPING THROUGH RESULTS
        for ($x = 0; $x < $answer_num; $x++) {
            $answer_data = $answer_rs->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> Assignment : <?php echo ($answer_data["title"]); ?></p>
                                <div class="description"><?php echo ($answer_data["subject_name"]); ?> (Updated <?php echo ($answer_data["datetime"]); ?>)</div>
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
                            <?php
                            
                            if ($answer_data["release"] == null) {
                            ?>

                                <div class="item">
                                    <a onclick="deleteAnswer('<?php echo ($answer_data['answer_id']); ?>')"><i class="trash icon"></i> Delete</a>
                                </div>
                                <div class="item">
                                    <button class="ui basic yellow button">Pending</button>
                                </div>

                            <?php
                            } else {

                            ?>

                                <div class="item">
                                    <button class="ui <?php if ($answer_data["release"] == 0) { ?>basic green<?php } else { ?>green<?php } ?> button"><?php if ($answer_data["release"] == 0) { ?>Marking Assigned<?php } else { ?>Marks : <?php echo ($answer_data["mark"]);
                                                                                                                                                                                                                                } ?></button>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    } else {
        //IF NO RESULTS ARE AVAILBLE
        ?>

        <!-- empty view -->
        <img src="resources/nothing.jpg" class="ui centered medium image">
        <div class="ui centered grid column">
            <p class="nothingText">Nothing yet...!</p>
        </div>
        <!-- empty view -->
<?php

    }
} else {
    //IF DATA ARE NOT RECEIVED PROPERLY
    echo ("1");
}

?>