<?php

require "connection.php";

if (isset($_POST["acc_type"])) {

    $initials = $_POST["initials"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $city = $_POST["city"];
    $district = $_POST["district"];
    $mobile = $_POST["mobile"];
    $acc_type = $_POST["acc_type"];

    if (empty($fname)) {
        echo ("First name cannot be empty!");
    } else if (strlen($fname) > 15) {
        echo ("First name cannot have more than 15 characters!");
    } else if (empty($lname)) {
        echo ("Last name cannot be empty!");
    } else if (strlen($lname) > 20) {
        echo ("Last name cannot have more than 20 characters!");
    } else if (strlen($line1) > 100) {
        echo ("Line 1 cannot have more than 100 characters");
    } else if (strlen($line2) > 100) {
        echo ("Line 2 cannot have more than 100 characters");
    } else if (strlen($mobile) != 10 && !empty($mobile)) {
        echo ("Mobile must have 10 characters");
    } else if (!preg_match("/07[01245678][0-9]/", $mobile) && !empty($mobile)) {
        echo ("Invalid mobile!!");
    } else {

        if ($acc_type == 1) {

            $student_rs = Database::search("SELECT * FROM `student` WHERE `email` = '" . $email . "'");
            $student_data = $student_rs->fetch_assoc();

            Database::iud("UPDATE `student` SET `initials` = '" . $initials . "',`first_name` = '" . $fname . "',`last_name` = '" . $lname . "',`gender_gender_id` = '" . $gender . "',`mobile` = '" . $mobile . "' 
            WHERE `email` = '" . $email . "'");

            echo ("success");

            if (!empty($line1) || $city != 0 || $district != 0) {

                if (empty($line1)) {
                    echo ("Address details incomplete. Line 1 cannot be empty.");
                } else if ($city == 0) {
                    echo ("Address details incomplete. Please select the city.");
                } else if ($district == 0) {
                    echo ("Address details incomplete. Please select the district.");
                } else {

                    $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $student_data["address_address_id"] . "'");
                    $address_num = $address_rs->num_rows;

                    if ($address_num == 0) {
                        Database::iud("INSERT INTO `address`(`line_1`,`line_2`,`city_city_id`,`district_district_id`) 
                        VALUES ('" . $line1 . "','" . $line2 . "','" . $city . "','" . $district . "')");
                    } else {
                        Database::iud("UPDATE `address` SET `line_1` = '" . $line1 . "',`line_2`='" . $line2 . "',
                        `city_city_id`='" . $city . "',`district_district_id`='" . $district . "' WHERE `address_id` = '" . $student_data["address_address_id"] . "'");
                    }
                }
            }

            if (isset($_FILES["image"])) {
                $image = $_FILES["image"];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $file_ex = $image["type"];

                if (!in_array($file_ex, $allowed_image_extentions)) {
                    echo ("Image update failed. Image type is invalid!");
                } else {
                    $new_file_extension;

                    if ($file_ex == "image/jpg") {
                        $new_file_extension = ".jpg";
                    } else if ($file_ex == "image/jpeg") {
                        $new_file_extension = ".jpeg";
                    } else if ($file_ex == "image/png") {
                        $new_file_extension = ".png";
                    } else if ($file_ex == "image/svg+xml") {
                        $new_file_extension = ".svg";
                    }

                    $file_name = "resources/profile_images/" . $email . "_" . uniqid() . $new_file_extension;
                    move_uploaded_file($image["tmp_name"], $file_name);

                    Database::iud("UPDATE `student` SET `pro_pic_path` = '" . $file_name . "' WHERE `email` = '" . $email . "'");
                }
            }
        } else if ($acc_type == 2) {

            $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email` = '" . $email . "'");
            $teacher_data = $teacher_rs->fetch_assoc();

            Database::iud("UPDATE `teacher` SET `initials` = '" . $initials . "',`first_name` = '" . $fname . "',`last_name` = '" . $lname . "',`gender_gender_id` = '" . $gender . "',`mobile` = '" . $mobile . "' 
            WHERE `email` = '" . $email . "'");

            echo ("success");

            if (!empty($line1) || $city != 0 || $district != 0) {

                if (empty($line1)) {
                    echo ("Address details incomplete. Line 1 cannot be empty.");
                } else if ($city == 0) {
                    echo ("Address details incomplete. Please select the city.");
                } else if ($district == 0) {
                    echo ("Address details incomplete. Please select the district.");
                } else {

                    $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $teacher_data["address_address_id"] . "'");
                    $address_num = $address_rs->num_rows;

                    if ($address_num == 0) {
                        Database::iud("INSERT INTO `address`(`line_1`,`line_2`,`city_city_id`,`district_district_id`) 
                        VALUES ('" . $line1 . "','" . $line2 . "','" . $city . "','" . $district . "')");
                    } else {
                        Database::iud("UPDATE `address` SET `line_1` = '" . $line1 . "',`line_2`='" . $line2 . "',
                        `city_city_id`='" . $city . "',`district_district_id`='" . $district . "' WHERE `address_id` = '" . $teacher_data["address_address_id"] . "'");
                    }
                }
            }

            if (isset($_FILES["image"])) {
                $image = $_FILES["image"];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $file_ex = $image["type"];

                if (!in_array($file_ex, $allowed_image_extentions)) {
                    echo ("Image update failed. Image type is invalid!");
                } else {
                    $new_file_extension;

                    if ($file_ex == "image/jpg") {
                        $new_file_extension = ".jpg";
                    } else if ($file_ex == "image/jpeg") {
                        $new_file_extension = ".jpeg";
                    } else if ($file_ex == "image/png") {
                        $new_file_extension = ".png";
                    } else if ($file_ex == "image/svg+xml") {
                        $new_file_extension = ".svg";
                    }

                    $file_name = "resources/profile_images/" . $email . "_" . uniqid() . $new_file_extension;
                    move_uploaded_file($image["tmp_name"], $file_name);

                    Database::iud("UPDATE `teacher` SET `pro_pic_path` = '" . $file_name . "' WHERE `email` = '" . $email . "'");
                }
            }
        } else if ($acc_type == 3) {

            $academic_officer_rs = Database::search("SELECT * FROM `academic_officer` WHERE `email` = '" . $email . "'");
            $academic_officer_data = $academic_officer_rs->fetch_assoc();

            Database::iud("UPDATE `academic_officer` SET `initials` = '" . $initials . "',`first_name` = '" . $fname . "',`last_name` = '" . $lname . "',`gender_gender_id` = '" . $gender . "',`mobile` = '" . $mobile . "' 
            WHERE `email` = '" . $email . "'");

            echo ("success");

            if (!empty($line1) || $city != 0 || $district != 0) {

                if (empty($line1)) {
                    echo ("Address details incomplete. Line 1 cannot be empty.");
                } else if ($city == 0) {
                    echo ("Address details incomplete. Please select the city.");
                } else if ($district == 0) {
                    echo ("Address details incomplete. Please select the district.");
                } else {

                    $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $academic_officer_data["address_address_id"] . "'");
                    $address_num = $address_rs->num_rows;

                    if ($address_num == 0) {
                        Database::iud("INSERT INTO `address`(`line_1`,`line_2`,`city_city_id`,`district_district_id`) 
                        VALUES ('" . $line1 . "','" . $line2 . "','" . $city . "','" . $district . "')");
                    } else {
                        Database::iud("UPDATE `address` SET `line_1` = '" . $line1 . "',`line_2`='" . $line2 . "',
                        `city_city_id`='" . $city . "',`district_district_id`='" . $district . "' WHERE `address_id` = '" . $academic_officer_data["address_address_id"] . "'");
                    }
                }
            }

            if (isset($_FILES["image"])) {
                $image = $_FILES["image"];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $file_ex = $image["type"];

                if (!in_array($file_ex, $allowed_image_extentions)) {
                    echo ("Image update failed. Image type is invalid!");
                } else {
                    $new_file_extension;

                    if ($file_ex == "image/jpg") {
                        $new_file_extension = ".jpg";
                    } else if ($file_ex == "image/jpeg") {
                        $new_file_extension = ".jpeg";
                    } else if ($file_ex == "image/png") {
                        $new_file_extension = ".png";
                    } else if ($file_ex == "image/svg+xml") {
                        $new_file_extension = ".svg";
                    }

                    $file_name = "resources/profile_images/" . $email . "_" . uniqid() . $new_file_extension;
                    move_uploaded_file($image["tmp_name"], $file_name);

                    Database::iud("UPDATE `academic_officer` SET `pro_pic_path` = '" . $file_name . "' WHERE `email` = '" . $email . "'");
                }
            }
        } else if ($acc_type == 4) {

            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $email . "'");
            $admin_data = $admin_rs->fetch_assoc();

            Database::iud("UPDATE `admin` SET `initials` = '" . $initials . "',`first_name` = '" . $fname . "',`last_name` = '" . $lname . "',`gender_gender_id` = '" . $gender . "',`mobile` = '" . $mobile . "' 
            WHERE `email` = '" . $email . "'");

            echo ("success");

            if (!empty($line1) || $city != 0 || $district != 0) {

                if (empty($line1)) {
                    echo ("Address details incomplete. Line 1 cannot be empty.");
                } else if ($city == 0) {
                    echo ("Address details incomplete. Please select the city.");
                } else if ($district == 0) {
                    echo ("Address details incomplete. Please select the district.");
                } else {

                    $address_rs = Database::search("SELECT * FROM `address` WHERE `address_id` = '" . $admin_data["address_address_id"] . "'");
                    $address_num = $address_rs->num_rows;

                    if ($address_num == 0) {
                        Database::iud("INSERT INTO `address`(`line_1`,`line_2`,`city_city_id`,`district_district_id`) 
                        VALUES ('" . $line1 . "','" . $line2 . "','" . $city . "','" . $district . "')");
                    } else {
                        Database::iud("UPDATE `address` SET `line_1` = '" . $line1 . "',`line_2`='" . $line2 . "',
                        `city_city_id`='" . $city . "',`district_district_id`='" . $district . "' WHERE `address_id` = '" . $admin_data["address_address_id"] . "'");
                    }
                }
            }

            if (isset($_FILES["image"])) {
                $image = $_FILES["image"];

                $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
                $file_ex = $image["type"];

                if (!in_array($file_ex, $allowed_image_extentions)) {
                    echo ("Image update failed. Image type is invalid!");
                } else {
                    $new_file_extension;

                    if ($file_ex == "image/jpg") {
                        $new_file_extension = ".jpg";
                    } else if ($file_ex == "image/jpeg") {
                        $new_file_extension = ".jpeg";
                    } else if ($file_ex == "image/png") {
                        $new_file_extension = ".png";
                    } else if ($file_ex == "image/svg+xml") {
                        $new_file_extension = ".svg";
                    }

                    $file_name = "resources/profile_images/" . $email . "_" . uniqid() . $new_file_extension;
                    move_uploaded_file($image["tmp_name"], $file_name);

                    Database::iud("UPDATE `admin` SET `pro_pic_path` = '" . $file_name . "' WHERE `email` = '" . $email . "'");
                }
            }
        } else {
            echo("1");
        }
    }
} else {
    echo ("1");
}
