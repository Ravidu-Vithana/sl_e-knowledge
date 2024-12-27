<?php
//STARTING THE SESSION
session_start();

//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//REQUIRING THE PTHER ESSENTIAL FILES FOR SENDING AN EMAIL
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

//START STORING DATA
$initials = $_POST["initials"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$grade = $_POST["grade"];
//END STORING DATA

//START VALIDATING DATA
if (preg_match("/[0-9]/", $initials)) {
    echo ("Initials cannot have a number!");
} else if (empty($fname)) {
    echo ("Please enter the First Name.");
} else if (strlen($fname) > 15) {
    echo ("First Name should have less than 15 characters.");
} else if (preg_match("/[0-9]/", $fname)) {
    echo ("First Name cannot have a number!");
} else if (empty($lname)) {
    echo ("Please enter the Last Name.");
} else if (strlen($lname) > 20) {
    echo ("Last Name should have less than 20 characters.");
} else if (preg_match("/[0-9]/", $lname)) {
    echo ("Last Name cannot have a number!");
} else if ($gender == 0) {
    echo ("Please select the gender.");
} else if (empty($email)) {
    echo ("Please enter the email.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Email is not valid!");
} else if (strlen($email) > 100) {
    echo ("Email should have less than 100 characters.");
} else if (empty($username)) {
    echo ("Please enter the username.");
} else if (!preg_match("/[A-Z]/", $username) || !preg_match("/[0-9]/", $username) || !preg_match("/[a-z]/", $username)) {
    echo ("Username must contain atleast one Uppercase letter, one lowercase letter and a digit.");
} else if (strlen($username) < 5 || strlen($username) > 20) {
    echo ("Username must have 5 - 20 characters.");
} else if (empty($password)) {
    echo ("Please enter the password.");
} else if (!preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[@#$%&]/", $password)) {
    echo ("Password must contain atleast one Uppercase letter, one lowercase letter, a digit and one of the special characters @,#,$,%,&.");
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo ("Password must have 8 - 20 characters.");
} else if (strlen($mobile) != 10 && !empty($mobile)) {
    echo ("Contact number should have 10 digits.");
} else if (!is_numeric($mobile) && !empty($mobile)) {
    echo ("Invalid number!");
} else if ($grade == 0) {
    echo ("Please select the grade.");
}else {
    //END VALIDATING DATA

    //CHECKING OF ANY OTHER STUDENT WITH THIS EMAIL
    $student_rs = Database::search("SELECT * FROM `student` WHERE `email` = '" . $email . "'");
    $student_num = $student_rs->num_rows;

    if ($student_num == 0) {
        //IF NO OTHER STUDENT WITH THIS EMAIL EXIST

        //CHECKING IF THIS USERNAME IS ALREADY BEING USED BY ANY OTHER USER
        $s_uname_rs = Database::search("SELECT * FROM `student` WHERE `username` = '" . $username . "'");
        $s_uname_num = $s_uname_rs->num_rows;

        $t_uname_rs = Database::search("SELECT * FROM `teacher` WHERE `username` = '" . $username . "'");
        $t_uname_num = $t_uname_rs->num_rows;

        $o_uname_rs = Database::search("SELECT * FROM `academic_officer` WHERE `username` = '" . $username . "'");
        $o_uname_num = $o_uname_rs->num_rows;

        $a_uname_rs = Database::search("SELECT * FROM `admin` WHERE `username` = '" . $username . "'");
        $a_uname_num = $a_uname_rs->num_rows;
        //END CHECKING USERNAME

        if ($s_uname_num == 0 && $t_uname_num == 0 && $o_uname_num == 0 && $a_uname_num == 0) {
            //IF USERNAME IS NOT USED BY ANYOTHER USER

            //CHECKING IF ANYOTHER STUDENT EXIST WITH THE SAME MOBILE NUMBER
            $mobile_rs = Database::search("SELECT * FROM `student` WHERE `mobile` = '" . $mobile . "'");
            $mobile_num = $mobile_rs->num_rows;

            //MOBILE NUMBER IS ALLOWED TO BE EMPTY. IF EMPTY, CODE IS CONTINUED
            if(empty($mobile)){
                $mobile_num = 0;
            }

            if ($mobile_num == 0) {
                //IF NO OTHER STUDENT HAS THE SAME MOBILE NUMBER

                //START SENDING EMAIL WITH THE USERNAME AND PASSWORD
                $vcode = uniqid();

                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'raviduyashith123@gmail.com';
                $mail->Password = 'izluoukjsomfqhpi';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('raviduyashith123@gmail.com', 'Student Registration');
                $mail->addReplyTo('raviduyashith123@gmail.com', 'Student Registration');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'SL e-Knowledge Student Registration Mail';
                $bodyContent = '<span>Welcome to SL e-Knowledge. Please use the following Username and Password to login.<br/><br/>
                <b>Username: </b>' . $username . '<br/>
                <b>Password: </b>' . $password . '<br/><br/>
                Please enter the following verification code for your first login.<br/><br/>
                <b>Verification Code: </b>' . $vcode . '<br/><br/> 
                You can change you Username and Password through the portal. Please do not share this information with anyone.</span>';
                $mail->Body    = $bodyContent;
                //END SENDING EMAIL

                if (!$mail->send()) {
                    //IF EMAIL SENDING FAILED
                    echo ("Invitation failed. Please try again.");
                } else {
                    //IF EMAIL SENDING SUCCESSFULL

                    //STORING NEW STUDENT IN THE DATABASE
                    Database::iud("INSERT INTO `student` (`initials`,`first_name`,`last_name`,`email`,`mobile`,`username`,`password`,
                    `verification_code`,`verified`,`status`,`joined_date`,`grade`,`gender_gender_id`) 
                    VALUES ('" . $initials . "','" . $fname . "','" . $lname . "','" . $email . "','" . $mobile . "','" . $username . "',
                    '" . $password . "','" . $vcode . "','0','1','" . $date . "','".$grade."','" . $gender . "')");

                    $acc_type_rs =  Database::search("SELECT * FROM `acc_type` WHERE `account` = 'Student'");
                    $acc_type_data = $acc_type_rs->fetch_assoc();

                    //STORING THE INVITE IN THE SENT TABLE
                    Database::iud("INSERT INTO `sent` (`first_name`,`last_name`,`email`,`username`,`password`,`acc_type_id`,`datetime`,`inviter_type`,`inviter_id`) 
                    VALUES ('".$fname."','".$lname."','".$email."','".$username."','".$password."','".$acc_type_data["id"]."','".$date."','3','".$_SESSION["officer"]["academic_officer_id"]."')");

                    echo ("success");
                }
            } else {
                //IF THE MOBILE NUMBER IS ALREADY BEING USED BY ANOTHER STUDENT
                echo ("This contact number is already being used!");
            }
        } else {
            //IF THE USERNAME IS ALREADY USED BY ANY OTHER USER
            echo ("This username has already been taken!");
        }
    } else {
        //IF THE EMAIL IS ALREADY BEING USED BY ANY OTHER STUDENT
        echo ("A Student with this email already exists!");
    }
}
