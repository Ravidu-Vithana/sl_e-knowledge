<?php

session_start();

require "connection.php";

if (isset($_SESSION["teacher"])) {

    $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email` = '" . $_SESSION["teacher"]["email"] . "'");
    $teacher_data = $teacher_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Portal</title>

        <link rel="stylesheet" href="semantic.css">
        <link rel="stylesheet" href="bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

    </head>

    <body onload="loadTeacherFiles()">

        <div class="ui grid">
            <div class="ui row">
                <div class="ui sixteen wide column">
                    <div class="ui row">
                        <div class="ui grid">
                            <div class="ui sixteen wide column mainheaderDiv">
                                <div class="ui stackable secondary menu">
                                    <a class="active item">
                                        <i class="home icon"></i> Home
                                    </a>
                                    <a class="item">
                                        <i class="info circle icon"></i> Need Help?
                                    </a>
                                    <a class="item">
                                        <i class="bug icon"></i> Report a Problem
                                    </a>
                                    <div class="right menu">
                                        <div class="item">
                                            <div class="ui primary button" onclick="signOut(2);"><i class="sign out alternate icon"></i> Sign Out</div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <hr style="border-color: rgba(130, 193, 255, 0.3);" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui row">
                        <div class="ui grid mainDiv">
                            <div class="ui mobile and tablet only sixteen wide column">
                                <div class="ui dropdown">
                                    <div class="ui blue basic button">Menu&nbsp;&nbsp;<i class="list icon"></i></div>
                                    <div class="menu sidePopMenu">
                                        <div class="header">My Profile</div>
                                        <div class="ui column sideheaderImageDiv">
                                            <?php

                                            $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $teacher_data["gender_gender_id"] . "'");
                                            $gender_data = $gender_rs->fetch_assoc();

                                            if ($teacher_data["pro_pic_path"] != null) {

                                            ?>

                                                <img class="ui fluid image" src="<?php echo ($teacher_data["pro_pic_path"]); ?>" />

                                                <?php

                                            } else {

                                                if ($gender_data["gender_name"] == "Male") {

                                                ?>

                                                    <img class="ui fluid image" src="resources/user_male.png" />

                                                <?php

                                                } else {

                                                ?>

                                                    <img class="ui fluid image" src="resources/user_female.jpg" />

                                            <?php

                                                }
                                            }

                                            ?>
                                        </div>
                                        <div class="ui centered fourteen wide column">
                                            <span class="sideHeaderProfile">Name : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($teacher_data["initials"] . " " . $teacher_data["first_name"] . " " . $teacher_data["last_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">Teacher ID : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($teacher_data["teacher_id"]) ?></span><br />
                                            <span class="sideHeaderProfile">Gender : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($gender_data["gender_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">Email : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($teacher_data["email"]) ?></span><br />

                                            <?php

                                            if ($teacher_data["mobile"] != "") {
                                            ?>

                                                <span class="sideHeaderProfile">Contact No : </span>
                                                <span class="sideHeaderProfileItems"><?php echo ($teacher_data["mobile"]) ?></span><br />

                                            <?php
                                            }

                                            if (!empty($teacher_data["address_address_id"])) {

                                                $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $teacher_data["address_address_id"] . "'");
                                                $address_data = $address_rs->fetch_assoc();

                                                $city_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '" . $address_data["city_city_id"] . "'");
                                                $city_data = $city_rs->fetch_assoc();

                                                $district_rs = Database::search("SELECT * FROM `district` WHERE `district_id` = '" . $address_data["district_district_id"] . "'");
                                                $district_data = $district_rs->fetch_assoc();

                                                $province_rs = Database::search("SELECT * FROM `province` WHERE `province_id` = '" . $district_data["province_province_id"] . "'");
                                                $province_data = $province_rs->fetch_assoc();

                                            ?>

                                                <span class="sideHeaderProfile">Address : </span><br />
                                                <span class="sideHeaderProfileItems"><?php echo ($address_data["line_1"]) ?></span><br />

                                                <?php

                                                if (!empty($address_data["line_2"])) {
                                                ?>

                                                    <span class="sideHeaderProfileItems"><?php echo ($address_data["line_2"]) ?></span><br />

                                                <?php
                                                }

                                                ?>

                                                <span class="sideHeaderProfile">City : </span><br />
                                                <span class="sideHeaderProfileItems"><?php echo ($city_data["city_name"]) ?></span><br />
                                                <span class="sideHeaderProfile">District : </span><br />
                                                <span class="sideHeaderProfileItems"><?php echo ($district_data["district_name"]) ?></span><br />
                                                <span class="sideHeaderProfile">Province : </span><br />
                                                <span class="sideHeaderProfileItems"><?php echo ($province_data["province_name"]) ?></span><br />

                                            <?php

                                            }

                                            ?>
                                            <span class="sideHeaderProfile">My Subjects : </span>

                                            <?php

                                            $teacher_has_subject_rs = Database::search("SELECT DISTINCT `subject_subject_id` FROM `teacher_has_subject` 
                                        WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");
                                            $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

                                            if ($teacher_has_subject_num == 0) {
                                            ?>

                                                <span class="sideHeaderProfileItems">None</span><br />

                                                <?php
                                            } else {

                                                for ($x = 0; $x < $teacher_has_subject_num; $x++) {

                                                    $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();

                                                    $subject_rs = Database::search("SELECT * FROM `subject` WHERE `subject_id` = '" . $teacher_has_subject_data["subject_subject_id"] . "'");
                                                    $subject_data = $subject_rs->fetch_assoc();

                                                ?>

                                                    <br /><span class="sideHeaderProfileItems"><?php echo ($subject_data["subject_name"]) ?></span>

                                            <?php

                                                }
                                            }

                                            ?>
                                        </div>
                                        <div class="item">
                                            <a class="item" onclick="updateProfileModal();">Update Profile</a>
                                        </div>
                                        <div class="header">Upload</div>
                                        <div class="item">
                                            <a class="item" onclick="upAsModal();">Assignment</a>
                                        </div>
                                        <div class="item">
                                            <a class="item" onclick="upNModal();">Lesson Note</a>
                                        </div>
                                        <div class="item">
                                            <a class="item" onclick="upMarksModal();">Marks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui vertical menu computer only sideheaderDiv column">
                                <div class="item">
                                    <div class="header">My Profile</div>
                                    <div class="ui column sideheaderImageDiv">
                                        <?php

                                        $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $teacher_data["gender_gender_id"] . "'");
                                        $gender_data = $gender_rs->fetch_assoc();

                                        if ($teacher_data["pro_pic_path"] != null) {

                                        ?>

                                            <img class="ui fluid image" src="<?php echo ($teacher_data["pro_pic_path"]); ?>" />

                                            <?php

                                        } else {

                                            if ($gender_data["gender_name"] == "Male") {

                                            ?>

                                                <img class="ui fluid image" src="resources/user_male.png" />

                                            <?php

                                            } else {

                                            ?>

                                                <img class="ui fluid image" src="resources/user_female.jpg" />

                                        <?php

                                            }
                                        }

                                        ?>
                                    </div>
                                    <div class="ui centered fourteen wide column">
                                        <span class="sideHeaderProfile">Name : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($teacher_data["initials"] . " " . $teacher_data["first_name"] . " " . $teacher_data["last_name"]) ?></span><br />
                                        <span class="sideHeaderProfile">Teacher ID : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($teacher_data["teacher_id"]) ?></span><br />
                                        <span class="sideHeaderProfile">Gender : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($gender_data["gender_name"]) ?></span><br />
                                        <span class="sideHeaderProfile">Email : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($teacher_data["email"]) ?></span><br />

                                        <?php

                                        if ($teacher_data["mobile"] != "") {
                                        ?>

                                            <span class="sideHeaderProfile">Contact No : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($teacher_data["mobile"]) ?></span><br />

                                        <?php
                                        }

                                        if (!empty($teacher_data["address_address_id"])) {

                                            $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $teacher_data["address_address_id"] . "'");
                                            $address_data = $address_rs->fetch_assoc();

                                            $city_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '" . $address_data["city_city_id"] . "'");
                                            $city_data = $city_rs->fetch_assoc();

                                            $district_rs = Database::search("SELECT * FROM `district` WHERE `district_id` = '" . $address_data["district_district_id"] . "'");
                                            $district_data = $district_rs->fetch_assoc();

                                            $province_rs = Database::search("SELECT * FROM `province` WHERE `province_id` = '" . $district_data["province_province_id"] . "'");
                                            $province_data = $province_rs->fetch_assoc();

                                        ?>

                                            <span class="sideHeaderProfile">Address : </span><br />
                                            <span class="sideHeaderProfileItems"><?php echo ($address_data["line_1"]) ?></span><br />

                                            <?php

                                            if (!empty($address_data["line_2"])) {
                                            ?>

                                                <span class="sideHeaderProfileItems"><?php echo ($address_data["line_2"]) ?></span><br />

                                            <?php
                                            }

                                            ?>

                                            <span class="sideHeaderProfile">City : </span><br />
                                            <span class="sideHeaderProfileItems"><?php echo ($city_data["city_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">District : </span><br />
                                            <span class="sideHeaderProfileItems"><?php echo ($district_data["district_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">Province : </span><br />
                                            <span class="sideHeaderProfileItems"><?php echo ($province_data["province_name"]) ?></span><br />

                                        <?php

                                        }

                                        ?>
                                        <span class="sideHeaderProfile">My Subjects : </span>

                                        <?php

                                        $teacher_has_subject_rs = Database::search("SELECT DISTINCT `subject_subject_id` FROM `teacher_has_subject` 
                                        WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");
                                        $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

                                        if ($teacher_has_subject_num == 0) {
                                        ?>

                                            <span class="sideHeaderProfileItems">None</span><br />

                                            <?php
                                        } else {

                                            for ($x = 0; $x < $teacher_has_subject_num; $x++) {

                                                $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();

                                                $subject_rs = Database::search("SELECT * FROM `subject` WHERE `subject_id` = '" . $teacher_has_subject_data["subject_subject_id"] . "'");
                                                $subject_data = $subject_rs->fetch_assoc();

                                            ?>

                                                <br /><span class="sideHeaderProfileItems"><?php echo ($subject_data["subject_name"]) ?></span>

                                        <?php

                                            }
                                        }

                                        ?>

                                    </div>
                                    <div class="menu">
                                        <button class="ui secondary basic fluid button" onclick="updateProfileModal();">Update Profile</button>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="header">Upload</div>

                                    <a class="item" onclick="upAsModal();">Assignment</a>
                                    <a class="item" onclick="upNModal();">Lesson Note</a>
                                    <a class="item" onclick="upMarksModal();">Marks</a>

                                </div>
                            </div>
                            <div class="ui column contentDiv">
                                <div class="ui grid container">
                                    <div class="ui sixteen wide column grid filterMenu">
                                        <div class="ui eight wide computer and sixteen wide mobile column">
                                            <div class="field">
                                                <label>Grade</label>
                                                <select class="ui fluid dropdown" id="grade" onchange="loadTeacherFiles()">
                                                    <?php

                                                    $grade_rs = Database::search("SELECT DISTINCT `grade` FROM `teacher_has_subject` 
                                                    WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");

                                                    if ($grade_rs->num_rows == 0) {
                                                    ?>

                                                        <option value="0">None</option>

                                                    <?php
                                                    } else {
                                                    ?>

                                                        <option value="0">-Select-</option>

                                                        <?php

                                                        for ($z = 0; $z < $grade_rs->num_rows; $z++) {

                                                            $grade_data = $grade_rs->fetch_assoc();

                                                        ?>

                                                            <option value="<?php echo ($grade_data["grade"]) ?>"><?php echo ($grade_data["grade"]) ?></option>

                                                    <?php

                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="ui seven wide computer and sixteen wide mobile column">
                                            <div class="field">
                                                <label>Subject</label>
                                                <select class="ui fluid dropdown" id="subject" onchange="loadTeacherFiles()">

                                                    <?php

                                                    $allsubjects_rs = Database::search("SELECT DISTINCT `subject_id`,`subject_name` FROM `teacher_has_subject` 
                                                    INNER JOIN `subject` ON `teacher_has_subject`.`subject_subject_id` = `subject`.`subject_id` 
                                                    WHERE `teacher_teacher_id` = '" . $_SESSION["teacher"]["teacher_id"] . "' ORDER BY `subject_id` ASC");

                                                    if ($allsubjects_rs->num_rows == 0) {
                                                    ?>

                                                        <option value="0">None</option>

                                                    <?php
                                                    } else {

                                                    ?>

                                                        <option value="0">All Assigned Subjects</option>

                                                        <?php

                                                        for ($a = 0; $a < $allsubjects_rs->num_rows; $a++) {
                                                            $allsubjects_data = $allsubjects_rs->fetch_assoc();

                                                        ?>

                                                            <option value="<?php echo ($allsubjects_data["subject_id"]) ?>"><?php echo ($allsubjects_data["subject_name"]) ?></option>

                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="ui four wide computer and sixteen wide mobile column" style="padding-top: 0px; padding-right: 0px;">
                                            <div class="ui fluid input">
                                                <input type="text" id="title" placeholder="Title or Name..." style="margin-top: 1rem;" onkeyup="loadTeacherFiles()">
                                            </div>
                                        </div>
                                        <div class="ui four wide computer and sixteen wide mobile column" style="padding-top: 0px;">
                                            <button class="ui labeled icon primary button" style="margin-top: 1rem;" onclick="loadTeacherFiles()"><i class="sync alternate icon"></i> Refresh</button>
                                        </div>
                                    </div>
                                    <div class="ui top attached tabular fluid stackable menu">
                                        <a class="item active" data-tab="assignmentView">
                                            My Assignments
                                        </a>
                                        <a class="item" data-tab="noteView">
                                            My Lesson Notes
                                        </a>
                                        <a class="item" data-tab="answerView">
                                            Answer Sheets
                                        </a>
                                        <a class="item" data-tab="marksView">
                                            Sent Marks
                                        </a>
                                    </div>

                                    <div class="ui bottom attached tab segment active contentDivViewArea" data-tab="assignmentView" id="teacherAssignmentView">
                                        <!-- content -->
                                    </div>
                                    <div class="ui bottom attached tab segment contentDivViewArea" data-tab="noteView" id="teacherNotesView">
                                        <!-- content -->
                                    </div>
                                    <div class="ui bottom attached tab segment contentDivViewArea" data-tab="answerView" id="teacherAnswerSheetView">
                                        <!-- content -->
                                    </div>
                                    <div class="ui bottom attached tab segment contentDivViewArea" data-tab="marksView" id="teacherMarksView">
                                        <!-- content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Profile Modal -->
        <div class="ui modal" id="updateProfileModal">
            <i class="close icon"></i>
            <div class="header">
                Update Profile
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="ui row">
                        <div class="ui sixteen wide grid column">

                            <?php

                            $image_status = 0;

                            $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $teacher_data["gender_gender_id"] . "'");
                            $gender_data = $gender_rs->fetch_assoc();

                            if ($teacher_data["pro_pic_path"] != null) {

                                $image_status = 1;

                            ?>

                                <img class="ui centered small bordered image" src="<?php echo ($teacher_data["pro_pic_path"]); ?>" id="proImg" />

                                <?php

                            } else {

                                if ($gender_data["gender_name"] == "Male") {

                                ?>

                                    <img class="ui centered small bordered image" src="resources/user_male.png" id="proImg" />

                                <?php

                                } else {

                                ?>

                                    <img class="ui centered small bordered image" src="resources/user_female.jpg" id="proImg" />

                            <?php

                                }
                            }

                            ?>

                            <div class="ui centered three wide computer and eight wide mobile column">
                                <input type="file" id="imageUploader" style="display: none;">
                                <label class="ui basic fluid positive button" for="imageUploader" onclick="viewImage();">Upload</label>
                            </div>

                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Initials</label>
                            <div class="ui fluid input">
                                <input type="text" id="initials" value="<?php echo ($teacher_data["initials"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>First Name</label>
                            <div class="ui fluid input">
                                <input type="text" id="fname" value="<?php echo ($teacher_data["first_name"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Last Name</label>
                            <div class="ui fluid input">
                                <input type="text" id="lname" value="<?php echo ($teacher_data["last_name"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Gender</label>
                            <select class="ui fluid dropdown" id="gender" onchange="updateAgain();">

                                <?php

                                $gender_rs = Database::search("SELECT * FROM `gender`");
                                $gender_num = $gender_rs->num_rows;

                                for ($x = 0; $x < $gender_num; $x++) {

                                    $gender_data = $gender_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($gender_data["gender_id"]); ?>" <?php if ($teacher_data["gender_gender_id"] == $gender_data["gender_id"]) {
                                                                                                ?> selected <?php
                                                                                                        } ?>><?php echo ($gender_data["gender_name"]); ?></option>

                                <?php

                                }

                                ?>
                            </select>
                        </div>
                        <div class="ui seven wide computer and sixteen wide mobile column">
                            <label>Email</label>
                            <div class="ui fluid input">
                                <input type="text" id="email" disabled value="<?php echo ($teacher_data["email"]); ?>">
                            </div>
                        </div>
                        <div class="ui five wide computer and sixteen wide mobile column">
                            <label>Contact No.</label>
                            <div class="ui fluid input">
                                <input type="tel" id="mobile" value="<?php echo ($teacher_data["mobile"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>

                        <?php

                        $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $teacher_data["address_address_id"] . "'");
                        $address_num = $address_rs->num_rows;

                        if ($address_num == 1) {
                            $address_data = $address_rs->fetch_assoc();

                        ?>

                            <div class="ui eight wide computer and sixteen wide mobile column">
                                <label>Address Line 1</label>
                                <div class="ui fluid input">
                                    <input type="text" id="line1" value="<?php echo ($address_data["line_1"]); ?>" onkeyup="updateAgain();">
                                </div>
                            </div>
                            <div class="ui eight wide computer and sixteen wide mobile column">
                                <label>Address Line 2</label>
                                <div class="ui fluid input">
                                    <input type="text" id="line2" value="<?php echo ($address_data["line_2"]); ?>" onkeyup="updateAgain();">
                                </div>
                            </div>

                        <?php

                        } else {

                        ?>

                            <div class="ui eight wide computer and sixteen wide mobile column">
                                <label>Address Line 1</label>
                                <div class="ui fluid input">
                                    <input type="text" id="line1" onkeyup="updateAgain();">
                                </div>
                            </div>
                            <div class="ui eight wide computer and sixteen wide mobile column">
                                <label>Address Line 2</label>
                                <div class="ui fluid input">
                                    <input type="text" id="line2" onkeyup="updateAgain();">
                                </div>
                            </div>

                        <?php

                        }

                        ?>
                        <div class="ui eight wide computer and sixteen wide mobile column">
                            <label>City</label>
                            <select class="ui fluid dropdown" id="city" onchange="updateAgain();">

                                <option value="0">-Select-</option>

                                <?php

                                $city_rs = Database::search("SELECT * FROM `city`");
                                $city_num = $city_rs->num_rows;

                                for ($y = 0; $y < $city_num; $y++) {

                                    $city_data = $city_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($city_data["city_id"]); ?>" <?php if ($address_num == 1) {
                                                                                                if ($address_data["city_city_id"] == $city_data["city_id"]) {
                                                                                            ?> selected <?php
                                                                                                    }
                                                                                                } ?>><?php echo ($city_data["city_name"]); ?></option>

                                <?php

                                }

                                ?>

                            </select>
                        </div>
                        <div class="ui eight wide computer and sixteen wide mobile column">
                            <label>District</label>
                            <select class="ui fluid dropdown" id="district" onchange="updateAgain();">

                                <option value="0">-Select-</option>

                                <?php

                                $district_rs = Database::search("SELECT * FROM `district`");
                                $district_num = $district_rs->num_rows;

                                for ($y = 0; $y < $district_num; $y++) {

                                    $district_data = $district_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($district_data["district_id"]); ?>" <?php if ($address_num) {
                                                                                                        if ($address_data["district_district_id"] == $district_data["district_id"]) {
                                                                                                    ?> selected <?php
                                                                                                            }
                                                                                                        } ?>><?php echo ($district_data["district_name"]); ?></option>

                                <?php

                                }

                                ?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui blue button" id="saveBtn" onclick="updateProfile('2',<?php echo ($image_status); ?>);">
                    Save
                </div>
                <div class="ui positive disabled button" id="okBtn">
                    Ok
                </div>
            </div>
        </div>
        <!-- Update Profile Modal -->

        <!-- Assignment upload modal -->
        <div class="ui modal" id="uploadAssignment">
            <i class="close icon"></i>
            <div class="header">
                Upload Assignment
            </div>
            <div class="content">

                <div class="ui grid">
                    <div class="ui centered twelve wide computer sixteen wide mobile column">
                        <label>Assignment Title</label>
                        <div class="ui fluid input">
                            <input type="text" placeholder="Title" id="titleAs">
                        </div>
                    </div>
                    <div class="ui centered eight wide computer sixteen wide mobile column">
                        <label>Grade</label>
                        <select class="ui fluid dropdown" id="gradeAs" onchange="loadSubAsModal();">
                            <?php

                            $teacher_has_subject_rs = Database::search("SELECT DISTINCT `grade` FROM `teacher_has_subject` 
                            WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");
                            $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

                            if ($teacher_has_subject_num == 0) {
                            ?>

                                <option value="0" selected>None</option>

                            <?php
                            } else {
                            ?>

                                <option value="0" selected>-Select-</option>

                                <?php

                                for ($z = 0; $z < $teacher_has_subject_num; $z++) {

                                    $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($teacher_has_subject_data["grade"]) ?>"><?php echo ($teacher_has_subject_data["grade"]) ?></option>

                            <?php

                                }
                            }

                            ?>

                        </select>
                    </div>
                    <div class="ui centered eight wide computer sixteen wide mobile column">
                        <label>Subject</label>

                        <select class="ui fluid dropdown" <?php if ($teacher_has_subject_num == 0) { ?> disabled <?php } ?> id="subjectAs">

                            <option value="0">Select Grade First</option>

                        </select>

                    </div>
                    <div class="ui centered sixteen wide column">

                        <div class="ui fluid action input">
                            <input type="file" style="display: none;" id="uploaderAs">
                            <input type="text" id="fileAs" disabled>
                            <label class="ui teal right labeled icon button" for="uploaderAs" onclick="viewAs();">
                                <i class="file pdf outline icon"></i>
                                Upload File
                            </label>
                        </div>
                        <span style="font-size: 12px;"><i>Only PDF files allowed*</i></span>
                    </div>
                </div>

            </div>
            <div class="actions">
                <span id="errMsgAs"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui positive right labeled icon button" onclick="uploadAs();">
                    Upload
                    <i class="arrow alternate circle up icon"></i>
                </div>
            </div>
        </div>
        <!-- Assignment upload modal -->

        <!-- Notes upload modal -->
        <div class="ui modal" id="uploadNote">
            <i class="close icon"></i>
            <div class="header">
                Upload Note
            </div>
            <div class="content">

                <div class="ui grid">
                    <div class="ui centered twelve wide computer sixteen wide mobile column">
                        <label>Note Title</label>
                        <div class="ui fluid input">
                            <input type="text" placeholder="Title" id="titleN">
                        </div>
                    </div>
                    <div class="ui centered eight wide computer sixteen wide mobile column">
                        <label>Grade</label>
                        <select class="ui fluid dropdown" id="gradeN" onchange="loadSubNModal();">
                            <?php

                            $teacher_has_subject_rs = Database::search("SELECT DISTINCT `grade` FROM `teacher_has_subject` 
                            WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");
                            $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

                            if ($teacher_has_subject_num == 0) {
                            ?>

                                <option value="0">None</option>

                            <?php
                            } else {
                            ?>

                                <option value="0">-Select-</option>

                                <?php

                                for ($z = 0; $z < $teacher_has_subject_num; $z++) {

                                    $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($teacher_has_subject_data["grade"]) ?>"><?php echo ($teacher_has_subject_data["grade"]) ?></option>

                            <?php

                                }
                            }

                            ?>

                        </select>
                    </div>
                    <div class="ui centered eight wide computer sixteen wide mobile column">
                        <label>Subject</label>

                        <select class="ui fluid dropdown" <?php if ($teacher_has_subject_num == 0) { ?> disabled <?php } ?> id="subjectN">

                            <option value="0">Select Grade First</option>

                        </select>

                    </div>
                    <div class="ui centered sixteen wide column">

                        <div class="ui fluid action input">
                            <input type="file" style="display: none;" id="uploaderN">
                            <input type="text" id="fileN" disabled>
                            <label class="ui teal right labeled icon button" for="uploaderN" onclick="viewN();">
                                <i class="file pdf outline icon"></i>
                                Upload File
                            </label>
                        </div>
                        <span style="font-size: 12px;"><i>Only PDF files allowed*</i></span>
                    </div>
                </div>

            </div>
            <div class="actions">
                <span id="errMsgN"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui positive right labeled icon button" onclick="uploadN();">
                    Upload
                    <i class="arrow alternate circle up icon"></i>
                </div>
            </div>
        </div>
        <!-- Notes upload modal -->

        <!-- Marks Upload modal -->
        <div class="ui modal" id="uploadMarks">
            <i class="close icon"></i>
            <div class="header">
                Upload Marks
            </div>
            <div class="content">

                <div class="ui grid">
                    <div class="ui four wide computer sixteen wide mobile column">
                        <label>Marks</label>
                        <div class="ui fluid input">
                            <input type="text" placeholder="Marks" id="marks">
                        </div>
                    </div>
                    <div class="ui centered four wide computer sixteen wide mobile column">
                        <label>Grade</label>
                        <select class="ui fluid dropdown" id="gradeM" onchange="loadStudentandAssignment();">
                            <?php

                            $teacher_has_subject_rs = Database::search("SELECT DISTINCT `grade` FROM `teacher_has_subject` 
                            WHERE `teacher_teacher_id` = '" . $teacher_data["teacher_id"] . "'");
                            $teacher_has_subject_num = $teacher_has_subject_rs->num_rows;

                            if ($teacher_has_subject_num == 0) {
                            ?>

                                <option value="0">None</option>

                            <?php
                            } else {
                            ?>

                                <option value="0">-Select-</option>

                                <?php

                                for ($z = 0; $z < $teacher_has_subject_num; $z++) {

                                    $teacher_has_subject_data = $teacher_has_subject_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($teacher_has_subject_data["grade"]) ?>"><?php echo ($teacher_has_subject_data["grade"]) ?></option>

                            <?php

                                }
                            }

                            ?>

                        </select>
                    </div>
                    <div class="ui centered eight wide computer sixteen wide mobile column">
                        <label>Student</label>
                        <select class="ui search fluid dropdown" id="student">
                            <option value="0">Select Grade First</option>
                        </select>
                    </div>
                    <div class="ui sixteen wide column">
                        <label>Assignment</label>
                        <select class="ui search fluid dropdown" id="assignment">
                            <option value="0">Select Grade First</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="actions">
                <span id="errMsgMarks"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui positive right labeled icon button" onclick="uploadMarks();">
                    Upload
                    <i class="arrow alternate circle up icon"></i>
                </div>
            </div>
        </div>
        <!-- Marks Upload modal -->

        <script src="jquery-3.6.3.js"></script>
        <script src="semantic.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location: teacher_login.php");
}

?>