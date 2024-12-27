<?php
//STARTING SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_GET["subject"]) && isset($_GET["title"])) {
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $student_grade = $_SESSION["student"]["grade"];
    $subject = $_GET["subject"];
    $title = $_GET["title"];
    //END OF STORING DATA

    //START CUSTOM QUERY CODE
    $query = "SELECT * FROM `notes` 
    INNER JOIN `teacher_has_subject` ON `teacher_has_subject`.`teacher_has_subject_id` = `notes`.`teacher_has_subject_id` 
    INNER JOIN `subject` ON `subject`.`subject_id` = `teacher_has_subject`.`subject_subject_id` 
    WHERE `grade` = '" . $student_grade . "'";

    if ($subject != 0) {
        //IF THE SUBJECT IS SELECTED
        $query .= " AND `subject_subject_id` = '" . $subject . "'";
    }

    if(!empty($title)){
        //IF A TITLE IS ENTERED
        $query.=" AND `title` LIKE '%".$title."%'";
    }
    //ORDER THE RESULTS BY DATETIME DESCENDING
    $query.=" ORDER BY `datetime` DESC";
    //END OF CUSTOM QUERY CODE

    $note_rs = Database::search($query);
    $note_num = $note_rs->num_rows;

    if ($note_num > 0) {
        //IF RESULTS ARE AVAILABLE

        //LOOPING THROUGH THE AVAILABLE RESULTS
        for ($x = 0; $x < $note_num; $x++) {
            $note_data = $note_rs->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> <?php echo ($note_data["title"]); ?></p>
                                <div class="description"><?php echo ($note_data["subject_name"]); ?> (Updated <?php echo ($note_data["datetime"]); ?>)</div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered six wide column grid file_item_action">
                        <div class="ui celled horizontal list">
                            <div class="item">
                                <a href="downloadPDF.php?file=<?php echo($note_data["path"]) ?>"><i class="download icon"></i> Download</a>
                            </div>
                            <div class="item">
                                <a href="<?php echo($note_data["path"]) ?>"><i class="eye icon"></i> View</a>
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
} else {
    //IF DATA IS NOT RECEIVED PROPERLY
    echo("1");
}

?>