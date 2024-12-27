<?php

session_start();

require "connection.php";

if (isset($_SESSION["admin"])) {

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $_SESSION["admin"]["email"] . "'");
    $admin_data = $admin_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Portal</title>

        <link rel="stylesheet" href="semantic.css">
        <link rel="stylesheet" href="style.css" />
    </head>

    <body onload="loadUsersInAdmin()">

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
                                        <i class="bug icon"></i> Reports
                                    </a>
                                    <div class="right menu">
                                        <div class="item">
                                            <div class="ui primary button" onclick="signOut(4);"><i class="sign out alternate icon"></i> Sign Out</div>
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

                                            $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $admin_data["gender_gender_id"] . "'");
                                            $gender_data = $gender_rs->fetch_assoc();

                                            if ($admin_data["pro_pic_path"] != null) {

                                            ?>

                                                <img class="ui fluid image" src="<?php echo ($admin_data["pro_pic_path"]); ?>" />

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
                                            <span class="sideHeaderProfileItems"><?php echo ($admin_data["initials"] . " " . $admin_data["first_name"] . " " . $admin_data["last_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">Admin ID : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($admin_data["admin_id"]) ?></span><br />
                                            <span class="sideHeaderProfile">Gender : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($gender_data["gender_name"]) ?></span><br />
                                            <span class="sideHeaderProfile">Email : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($admin_data["email"]) ?></span><br />

                                            <?php

                                            if ($admin_data["mobile"] != "") {
                                            ?>

                                                <span class="sideHeaderProfile">Contact No : </span>
                                                <span class="sideHeaderProfileItems"><?php echo ($admin_data["mobile"]) ?></span><br />

                                            <?php

                                            }

                                            if (!empty($admin_data["address_address_id"])) {

                                                $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $admin_data["address_address_id"] . "'");
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

                                        </div>
                                        <div class="item">
                                            <a class="item" onclick="updateProfileModal();">Update Profile</a>
                                        </div>
                                        <div class="header">Add New</div>
                                        <div class="item">
                                            <a class="item" onclick="addOfficerModal();">Academic Officer</a>
                                        </div>
                                        <div class="item">
                                            <a class="item" onclick="addTeacherModal();">Teacher</a>
                                        </div>
                                        <div class="header">View</div>
                                        <div class="item">
                                            <a class="item" onclick="sentInvModalAd();">Sent Invitations</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui vertical menu computer only sideheaderDiv column">
                                <div class="item">
                                    <div class="header">My Profile</div>
                                    <div class="ui column sideheaderImageDiv">
                                        <?php

                                        $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $admin_data["gender_gender_id"] . "'");
                                        $gender_data = $gender_rs->fetch_assoc();

                                        if ($admin_data["pro_pic_path"] != null) {

                                        ?>

                                            <img class="ui fluid image" src="<?php echo ($admin_data["pro_pic_path"]); ?>" />

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
                                        <span class="sideHeaderProfileItems"><?php echo ($admin_data["initials"] . " " . $admin_data["first_name"] . " " . $admin_data["last_name"]) ?></span><br />
                                        <span class="sideHeaderProfile">Admin ID : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($admin_data["admin_id"]) ?></span><br />
                                        <span class="sideHeaderProfile">Gender : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($gender_data["gender_name"]) ?></span><br />
                                        <span class="sideHeaderProfile">Email : </span>
                                        <span class="sideHeaderProfileItems"><?php echo ($admin_data["email"]) ?></span><br />

                                        <?php

                                        if ($admin_data["mobile"] != "") {
                                        ?>

                                            <span class="sideHeaderProfile">Contact No : </span>
                                            <span class="sideHeaderProfileItems"><?php echo ($admin_data["mobile"]) ?></span><br />

                                        <?php

                                        }

                                        if (!empty($admin_data["address_address_id"])) {

                                            $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $admin_data["address_address_id"] . "'");
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
                                    </div>
                                    <div class="menu">
                                        <button class="ui secondary basic fluid button" onclick="updateProfileModal();">Update Profile</button>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="header">Add New</div>

                                    <a class="item" onclick="addOfficerModal();">Academic Officer</a>
                                    <a class="item" onclick="addTeacherModal();">Teacher</a>


                                    <div class="header">View</div>

                                    <a class="item" onclick="sentInvModalAd();">Sent Invitations</a>

                                </div>
                            </div>
                            <div class="ui column contentDiv">
                                <div class="ui grid container">
                                    <div class="ui sixteen wide column grid filterMenu">
                                        <div class="ui sixteen wide column">
                                            <div class="ui search">
                                                <div class="ui icon input">
                                                    <input type="text" placeholder="Search..." id="search" onkeyup="loadUsersInAdmin()">
                                                    <i class="search icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ui four wide computer and sixteen wide mobile column" style="padding-top: 0px;">
                                            <button class="ui labeled icon primary button" style="margin-top: 1rem;" onclick="loadUsersInAdmin()"><i class="sync alternate icon"></i> Refresh</button>
                                        </div>
                                    </div>
                                    <div class="ui top attached tabular fluid stackable menu">
                                        <a class="item active" data-tab="officerView">
                                            Manage Academic Officers
                                        </a>
                                        <a class="item" data-tab="teacherView">
                                            Manage Teachers
                                        </a>
                                        <a class="item" data-tab="studentView">
                                            Manage Students
                                        </a>
                                    </div>

                                    <div class="ui bottom attached tab segment active contentDivViewArea" data-tab="officerView" id="officerView">
                                        <!-- content -->
                                    </div>
                                    <div class="ui bottom attached tab segment contentDivViewArea" data-tab="teacherView" id="teacherView">
                                        <!-- content -->
                                    </div>
                                    <div class="ui bottom attached tab segment contentDivViewArea" data-tab="studentView" id="studentView">
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

                            $gender_rs = Database::search("SELECT * FROM `gender` WHERE `gender_id` = '" . $admin_data["gender_gender_id"] . "'");
                            $gender_data = $gender_rs->fetch_assoc();

                            if ($admin_data["pro_pic_path"] != null) {

                                $image_status = 1;

                            ?>

                                <img class="ui centered small bordered image" src="<?php echo ($admin_data["pro_pic_path"]); ?>" id="proImg" />

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
                                <input type="text" id="initials" value="<?php echo ($admin_data["initials"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>First Name</label>
                            <div class="ui fluid input">
                                <input type="text" id="fname" value="<?php echo ($admin_data["first_name"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Last Name</label>
                            <div class="ui fluid input">
                                <input type="text" id="lname" value="<?php echo ($admin_data["last_name"]); ?>" onkeyup="updateAgain();">
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

                                    <option value="<?php echo ($gender_data["gender_id"]); ?>" <?php if ($admin_data["gender_gender_id"] == $gender_data["gender_id"]) {
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
                                <input type="text" id="email" disabled value="<?php echo ($admin_data["email"]); ?>">
                            </div>
                        </div>
                        <div class="ui five wide computer and sixteen wide mobile column">
                            <label>Contact No.</label>
                            <div class="ui fluid input">
                                <input type="tel" id="mobile" value="<?php echo ($admin_data["mobile"]); ?>" onkeyup="updateAgain();">
                            </div>
                        </div>

                        <?php

                        $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $admin_data["address_address_id"] . "'");
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
                <div class="ui blue button" id="saveBtn" onclick="updateProfile('4',<?php echo ($image_status); ?>);">
                    Save
                </div>
                <div class="ui positive disabled button" id="okBtn">
                    Ok
                </div>
            </div>
        </div>
        <!-- Update Profile Modal -->

        <!-- Add Teacher Modal -->
        <div class="ui modal" id="addTeacherModal">
            <i class="close icon"></i>
            <div class="header">
                Add New Teacher
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="ui row">
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Initials</label>
                            <div class="ui fluid input">
                                <input type="text" id="initialsT" value="">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>First Name<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="fnameT">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Last Name<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="lnameT">
                            </div>
                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Gender<span class="req">*</span></label>
                            <select class="ui fluid dropdown" id="genderT">

                                <option value="0">-Select-</option>

                                <?php

                                $gender_rs = Database::search("SELECT * FROM `gender`");
                                $gender_num = $gender_rs->num_rows;

                                for ($x = 0; $x < $gender_num; $x++) {

                                    $gender_data = $gender_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($gender_data["gender_id"]); ?>"><?php echo ($gender_data["gender_name"]); ?></option>

                                <?php

                                }

                                ?>
                            </select>
                        </div>
                        <div class="ui twelve wide computer and sixteen wide mobile column">
                            <label>Email<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="emailT">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Username<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="usernameT">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Password<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="passwordT">
                            </div>
                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Contact No.</label>
                            <div class="ui fluid input">
                                <input type="text" id="mobileT">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <span id="waitT"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui positive right labeled icon button" onclick="addTeacher();">
                    Add
                    <i class="plus circle icon"></i>
                </div>
            </div>
        </div>
        <!-- Add Teacher Modal -->

        <!-- Add Officer Modal -->
        <div class="ui modal" id="addOfficerModal">
            <i class="close icon"></i>
            <div class="header">
                Add New Academic Officer
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="ui row">
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Initials</label>
                            <div class="ui fluid input">
                                <input type="text" id="initialsAc" value="">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>First Name<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="fnameAc">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Last Name<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="lnameAc">
                            </div>
                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Gender<span class="req">*</span></label>
                            <select class="ui fluid dropdown" id="genderAc">

                                <option value="0">-Select-</option>

                                <?php

                                $gender_rs = Database::search("SELECT * FROM `gender`");
                                $gender_num = $gender_rs->num_rows;

                                for ($x = 0; $x < $gender_num; $x++) {

                                    $gender_data = $gender_rs->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($gender_data["gender_id"]); ?>"><?php echo ($gender_data["gender_name"]); ?></option>

                                <?php

                                }

                                ?>
                            </select>
                        </div>
                        <div class="ui twelve wide computer and sixteen wide mobile column">
                            <label>Email<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="emailAc">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Username<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="usernameAc">
                            </div>
                        </div>
                        <div class="ui six wide computer and sixteen wide mobile column">
                            <label>Password<span class="req">*</span></label>
                            <div class="ui fluid input">
                                <input type="text" id="passwordAc">
                            </div>
                        </div>
                        <div class="ui four wide computer and sixteen wide mobile column">
                            <label>Contact No.</label>
                            <div class="ui fluid input">
                                <input type="text" id="mobileAc">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <span id="waitAc"></span>

                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui positive right labeled icon button" onclick="addOfficer();">
                    Add
                    <i class="plus circle icon"></i>
                </div>
            </div>
        </div>
        <!-- Add Officer Modal -->

        <!-- Sent Invitations Modal -->
        <div class="ui modal" id="sentInvitations">
            <i class="close icon"></i>
            <div class="header">
                Sent Invitations
            </div>
            <div class="scrolling content" id="loadInv">

            </div>
            <div class="actions">
                <div class="ui black deny button">
                    Close
                </div>
            </div>
        </div>
        <!-- Sent Invitations Modal -->

        <!-- Change Grade Modal -->
        <div class="ui modal" id="changeGrade">
            <i class="close icon"></i>
            <div class="header">
                Change Grade
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="ui row" id="content" style="min-height: 5rem;">
                        <div class="ui active dimmer">
                            <div class="ui centered inline loader"></div>
                        </div>
                        <!-- content -->
                    </div>
                </div>
            </div>
            <div class="actions">
                <span id="err"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui primary button" onclick="changeGrade()">
                    Save
                </div>
            </div>
        </div>
        <!-- Change Grade Modal -->

        <!-- Assign Subject Modal -->
        <div class="ui modal" id="assignSubject">
            <i class="close icon"></i>
            <div class="header">
                Assign Subject
            </div>
            <div class="content">
                <div class="ui grid">
                    <div class="ui row">
                        <div class="ui sixteen wide column" id="currentSubjectsView">
                            <!-- content -->
                        </div>
                    </div>
                    <div class="ui row">
                        <div class="ui seven wide computer and sixteen wide mobile column">
                            <label>Grade</label>
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
                        <div class="ui seven wide computer and sixteen wide mobile column">
                            <label>Subject</label>
                            <select class="ui fluid dropdown" id="subject">
                                <option value="0">All Subjects</option>
                                <?php

                                $subject = Database::search("SELECT * FROM `subject`");

                                for ($z = 0; $z < $subject->num_rows; $z++) {

                                    $subject_data = $subject->fetch_assoc();

                                ?>

                                    <option value="<?php echo ($subject_data["subject_id"]) ?>"><?php echo ($subject_data["subject_name"]) ?></option>

                                <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <span id="errAssign"></span>
                <div class="ui black deny button">
                    Cancel
                </div>
                <div class="ui primary button" onclick="assignSubject()">
                    Save
                </div>
            </div>
        </div>
        <!-- Assign Subject Modal -->

        <script src="jquery-3.6.3.js"></script>
        <script src="semantic.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location: admin_login.php");
}

?>