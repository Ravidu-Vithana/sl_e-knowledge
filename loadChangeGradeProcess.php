<?php

//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE RECEIVED DATA ARE SET PROPERLY
if (isset($_GET["id"])) {
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $id = $_GET["id"];
    //END STROING DATA

    //GETTING THE RELEVANT STIUDENT DATA
    $results = Database::search("SELECT * FROM `student` WHERE `student_id`='" . $id . "'");

    if ($results->num_rows == 1) {
        //IF ONE STUDENT DATA ROW IS AVAILABLE

        $results_data = $results->fetch_assoc();

?>

        <div class="ui four wide computer and sixteen wide mobile column">
            <span class="sideHeaderProfile">ID : </span>
            <span class="sideHeaderProfileItems" id="idField"><?php echo($results_data["student_id"]) ?></span>
        </div>
        <div class="ui four wide computer and sixteen wide mobile column">
            <span class="sideHeaderProfile">Name : </span>
            <span class="sideHeaderProfileItems" id="nameField"><?php echo($results_data["initials"]." ".$results_data["first_name"]." ".$results_data["last_name"]) ?></span>
        </div>
        <div class="ui four wide computer and sixteen wide mobile column">
            <span class="sideHeaderProfile">Current Grade : </span>
            <span class="sideHeaderProfileItems" id="currentGradeField"><?php echo($results_data["grade"]) ?></span>
        </div>
        <div class="ui four wide computer and sixteen wide mobile column">
            <label>New Grade</label>
            <select class="ui fluid dropdown" id="grade">
                <option value="0">-Select-</option>
                <?php

                $grade = Database::search("SELECT * FROM `grade`");

                for ($z = 0; $z < $grade->num_rows; $z++) {

                    $grade_data = $grade->fetch_assoc();

                ?>

                    <option value="<?php echo ($grade_data["grade_id"]) ?>"><?php echo ($grade_data["grade"]) ?></option>

                <?php
                }

                ?>
            </select>
        </div>

<?php

    } else {
        //IF NO STUDENT DATA ROW IS AVAILABLE, ERROR IS SENT BACK
        echo ("1");
    }
} else {
    //IF THE DATA IS NOT RECEIVED PROPERLY
    echo ("1");
}

?>