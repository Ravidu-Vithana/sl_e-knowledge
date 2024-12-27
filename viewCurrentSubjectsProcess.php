<?php

require "connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

?>

    <span class="sideHeaderProfile">Current Subjects : </span><br/>

    <?php

    $results = Database::search("SELECT * FROM `teacher_has_subject` 
    INNER JOIN `subject` ON `teacher_has_subject`.`subject_subject_id` = `subject`.`subject_id` 
    WHERE `teacher_teacher_id` = '" . $id . "'");

    if ($results->num_rows == 0) {
    ?>
        <span class="sideHeaderProfileItems" id="idField">None</span><br/>
        <?php
    } else {
        for ($x = 0; $x < $results->num_rows; $x++) {
            $results_data = $results->fetch_assoc();

        ?>

            <span class="sideHeaderProfileItems" id="idField"><?php echo($results_data["subject_name"]) ?> (Grade : <?php echo($results_data["grade"]) ?>)</span><br/>

<?php

        }
    }
}

?>