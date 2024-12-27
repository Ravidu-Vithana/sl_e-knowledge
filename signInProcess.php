<?php
//STARTING THE SESSION
session_start();
//REQUIRING DATABASE CONNECTION
require "connection.php";

//REQUIRING OTHER ESSENTIALS FOR EMAIL SENDING
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_POST["u"]) && isset($_POST["p"]) && isset($_POST["r"]) && isset($_POST["acc_type"])) {
    //IF THE DARA ARE RECEIVED PROPERLY

    //START STORING DATA
    $uname = $_POST["u"];
    $password = $_POST["p"];
    $rememberMe = $_POST["r"];
    $acc_type = $_POST["acc_type"];
    $code = uniqid();
    //END STORING DATA

    //START VALIDATION
    if (empty($uname)) {
        echo ("Please enter the Username!");
    } else if (strlen($uname) > 20 || strlen($uname) < 8) {
        echo ("Username should contain 8 - 20 characters!");
    } else if (!preg_match("/[A-Z]/", $uname) || !preg_match("/[0-9]/", $uname) || !preg_match("/[a-z]/", $uname)) {
        echo ("Invalid username!");
    } else if (empty($password)) {
        echo ("Please enter the password!");
    } else if (!preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[@#$%&]/", $password)) {
        echo ("Invalid password!");
    } else if (strlen($password) < 8 || strlen($password) > 20) {
        echo ("Password must contain 8 - 20 characters!");
    } else {
        //END VALIDATION

        //CHECKING THE ACCOUNT TYPES
        if ($acc_type == 1) {
            //IF ACCOUNT TYPE IS STUDENT

            //SEARCHING A STUDENT WITH CURRENT USERNAME AND PASSWORD
            $student_rs = Database::search("SELECT * FROM `student` WHERE `username` = '" . $uname . "' 
        AND `password` = '" . $password . "'");
            $student_num = $student_rs->num_rows;

            if ($student_num == 1) {
                //IF RESULTS AVAIABLE
                $student_data = $student_rs->fetch_assoc();

                if ($student_data["status"] == 1) {
                    //IF THE STUDENT IS ACTIVE
                    if ($rememberMe == "true") {
                        //STORING USERNAME AND PASSWORD IN COOKIES IF REMEMBER ME IS CHECKED
                        setcookie("stu", $uname, time() + (60 * 60 * 24 * 365));
                        setcookie("stp", $password, time() + (60 * 60 * 24 * 365));
                    } else {
                        //DELETING ANY AVAILABLE COOKIES STORING USERNAME AND PASSWORD IF REMEMBER ME IS NOT CHECKED
                        setcookie("stu", "", -1);
                        setcookie("stp", "", -1);
                    }

                    if ($student_data["verified"] == 1) {
                        //IF THE STUDENT IS VERIFIED
                        if ($student_data["portal_fee_status"] == 1) {
                            //IF THE STUDENT HAS PAID THE PORTAL FEE
                            if ($student_data["enrollment_fee_status"] == 1) {
                                //IF ANY ENROLLMENT FEES ARE PAID
                                $_SESSION["student"] = $student_data;
                                echo ("success");
                            } else {
                                //IF ENROLLMENT FEE NOT PAUD
                                echo ("You have been promoted. Please pay the enrollment fee to login to the portal.");
                            }
                        } else {
                            //IF STUDENT HAS NOT PAID THE PORTAL FEE

                            //GETTING TODAY DATE
                            $d = new DateTime();
                            $tz = new DateTimeZone("Asia/Colombo");
                            $d->setTimezone($tz);
                            $date = $d->format("Y-m-d H:i:s");

                            //COMPARING TODAY WITH THE STUDENT JOINED DATE
                            $date1 = new DateTime($student_data["joined_date"]);
                            $date2 = new DateTime($date);

                            $interval = $date1->diff($date2);

                            if ($interval->y == 0) {
                                //IF THE NUMBER OF YEAR IS 0
                                if ($interval->m > 0) {
                                    //IF NUMBER OF MONTHS GREATER THAN 0
                                    echo ("4");
                                } else {
                                    if ($student_data["enrollment_fee_status"] == 1) {
                                        $_SESSION["student"] = $student_data;
                                        echo ("3");
                                    } else {
                                        echo ("You have been promoted. Please pay the enrollment fee to login to the portal.");
                                    }
                                }
                            } else {
                                //IF THE NUMBER OF YEARS IS GREATER THAN 0
                                echo ("4");
                            }
                        }
                    } else {
                        //IF STUDENT NOT VERIFIED
                        $_SESSION["vStudent"]["uname"] = $uname;
                        $_SESSION["vStudent"]["password"] = $password;

                        //UPDATING VERIFICATION CODE OF THE RELEVANT STUDENT
                        Database::iud("UPDATE `student` SET `verification_code` = '" . $code . "' WHERE `username` = '" . $uname . "' AND `password` = '" . $password . "'");

                        //SENDING AN EMAIL WITH THE VERIFICATION CODE
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'raviduyashith123@gmail.com';
                        $mail->Password = 'izluoukjsomfqhpi';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                        $mail->setFrom('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addReplyTo('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addAddress($student_data["email"]);
                        $mail->isHTML(true);
                        $mail->Subject = 'SL e-Knowledge Student Verification Code';
                        $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Academic Officer.</span>';
                        $mail->Body    = $bodyContent;

                        if (!$mail->send()) {
                            //IF THE EMAIL NOT SENT
                            echo ("Verification Code sending failed. Please try again later");
                        } else {
                            //IF THE EMAIL SENT
                            echo ("2");
                        }
                    }
                } else {
                    //IF THE STUDENT IS BEING BLOCKED BY THE ADMIN
                    echo ("You have been blocked by the admin. Please contact your Academic officer");
                }
            } else {
                //IF THE USERNAME OR PASSOWRD IS INVALID
                echo ("Invalid User");
            }
        } else if ($acc_type == 2) {
            //IF THE ACCOUNT TYPE IS TEACHER

            //SEARCHING FOR A TEACHER WITH THE USERNAME AND PASSWORD
            $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `username` = '" . $uname . "' 
        AND `password` = '" . $password . "'");
            $teacher_num = $teacher_rs->num_rows;

            if ($teacher_num == 1) {
                //IF RESULTS AVAILABLE
                $teacher_data = $teacher_rs->fetch_assoc();

                if ($teacher_data["status"] == 1) {
                    //IF THE TEACHER IS ACTIVE
                    if ($rememberMe == "true") {
                        //IF REMEMBER ME TICKED, USERNAME AND PASSWORD STORED IN COOKIES
                        setcookie("teu", $uname, time() + (60 * 60 * 24 * 365));
                        setcookie("tep", $password, time() + (60 * 60 * 24 * 365));
                    } else {
                        //IF REMEMBER ME UNTICKED, COOKIES WITH USERNAME PASSWORD ARE DESTROYED
                        setcookie("teu", "", -1);
                        setcookie("tep", "", -1);
                    }

                    if ($teacher_data["verified"] == 1) {
                        //IF THE TEACHER IS VERIFIED
                        $_SESSION["teacher"] = $teacher_data;

                        echo ("success");
                    } else {
                        //IF THE TEACHER IS NOT VERIFIED
                        $_SESSION["vTeacher"]["uname"] = $uname;
                        $_SESSION["vTeacher"]["password"] = $password;

                        //UPDATING THE VERIFICATION CODE IN THE DATABASE
                        Database::iud("UPDATE `teacher` SET `verification_code` = '" . $code . "' WHERE `username` = '" . $uname . "' AND `password` = '" . $password . "'");

                        //SENDING THE EMAIL WITH VERIFICATION CODE
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'raviduyashith123@gmail.com';
                        $mail->Password = 'izluoukjsomfqhpi';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                        $mail->setFrom('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addReplyTo('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addAddress($teacher_data["email"]);
                        $mail->isHTML(true);
                        $mail->Subject = 'SL e-Knowledge Teacher Verification Code';
                        $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Academic Officer.</span>';
                        $mail->Body    = $bodyContent;

                        if (!$mail->send()) {
                            //IF THE EMAIL NOT SENT
                            echo ("Verification Code sending failed. Please try again later");
                        } else {
                            //IF THE EMAIL SENT
                            echo ("2");
                        }
                    }
                } else {
                    //IF THE TEACHER HAS BEEN BLOCKED BY THE ADMIN
                    echo ("You have been blocked by the admin. Please contact the Admin");
                }
            } else {
                //IF NO TEACHER EXISTS FOR THE GIVEN USERNAME AND PASSWORD
                echo ("Invalid User");
            }
        } else if ($acc_type == 3) {
            //IF THE ACCOUNT TYPE IS ACADEMIC OFFICER

            //SEARCHING ACADEMIC OFFICERS WITH THIS USERNAME AND PASSWORD
            $academic_officer_rs = Database::search("SELECT * FROM `academic_officer` WHERE `username` = '" . $uname . "' 
            AND `password` = '" . $password . "'");
            $academic_officer_num = $academic_officer_rs->num_rows;

            if ($academic_officer_num == 1) {
                //IF RESULTS AVAILABLE
                $academic_officer_data = $academic_officer_rs->fetch_assoc();

                if ($academic_officer_data["status"] == 1) {
                    //IF THE ACADEMIC OFFICER IS ACTIVE
                    if ($rememberMe == "true") {
                        //REMEMBER ME CHECKED. STORING USERNAME AND PASSWORD IN COOKIES
                        setcookie("ofu", $uname, time() + (60 * 60 * 24 * 365));
                        setcookie("ofp", $password, time() + (60 * 60 * 24 * 365));
                    } else {
                        //REMEMBER ME UNCHECKED. DELETING ANY COOKIES WITH THE USERNAME AND PASSWORD STORED
                        setcookie("ofu", "", -1);
                        setcookie("ofp", "", -1);
                    }

                    if ($academic_officer_data["verified"] == 1) {
                        //IF THE ACADEMIC OFFICER IS VERIFIED
                        $_SESSION["officer"] = $academic_officer_data;

                        echo ("success");
                    } else {
                        //IF THE ACADEMIC OFFICER IS NOT VERIFIED
                        $_SESSION["vOfficer"]["uname"] = $uname;
                        $_SESSION["vOfficer"]["password"] = $password;

                        //UPDATING THE VERIFICATION CODE FOR THAT ACADEMIC OFFICER IN THE DATABASE
                        Database::iud("UPDATE `academic_officer` SET `verification_code` = '" . $code . "' WHERE `username` = '" . $uname . "' AND `password` = '" . $password . "'");

                        //SENDING EMAIL WITH VERIFICATION CODE
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'raviduyashith123@gmail.com';
                        $mail->Password = 'izluoukjsomfqhpi';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;
                        $mail->setFrom('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addReplyTo('raviduyashith123@gmail.com', 'Reset Password');
                        $mail->addAddress($academic_officer_data["email"]);
                        $mail->isHTML(true);
                        $mail->Subject = 'SL e-Knowledge Academic Officer Verification Code';
                        $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Admin.</span>';
                        $mail->Body    = $bodyContent;

                        if (!$mail->send()) {
                            //IF THE EMAIL NOT SENT
                            echo ("Verification Code sending failed. Please try again later");
                        } else {
                            //IF THE EMAIL SENT
                            echo ("2");
                        }
                    }
                } else {
                    //IF THE ACADEMIC OFFICER IS BLOCKED BY THE ADMIN
                    echo ("You have been blocked by the admin. Please contact the Admin");
                }
            } else {
                //IF NO ACADEMIC OFFICER EXISTS FOR THE GIVEN USERNAME AND PASSWORD
                echo ("Invalid User");
            }
        } else if ($acc_type == 4) {
            //IF THE ACCOUNT TYPE IS ADMIN

            //SEARCHING AN ADMIN WITH THIS USERNAME AND PASSWORD
            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `username` = '" . $uname . "' 
            AND `password` = '" . $password . "'");
            $admin_num = $admin_rs->num_rows;

            if ($admin_num == 1) {
                //IF RESULTS AVAILABLE
                $admin_data = $admin_rs->fetch_assoc();

                $_SESSION["admin"] = $admin_data;

                if ($rememberMe == "true") {
                    //REMEMBER ME CHECKED. USERNAME AND PASSWORD IS STORED IN COOKIES
                    setcookie("adu", $uname, time() + (60 * 60 * 24 * 365));
                    setcookie("adp", $password, time() + (60 * 60 * 24 * 365));
                } else {
                    //REMEMBER ME UNCHECKED. DELETING ANY COOKIES WITH THE USERNAME AND PASSWORD
                    setcookie("adu", "", -1);
                    setcookie("adp", "", -1);
                }

                echo ("success");
            } else {
                //IF NO ADMIN EXISTS FOR THE GIVEN USERNAME AND PASSWORD
                echo ("Invalid User");
            }
        } else {
            //IF ANY OTHER ACCOUNT TYPE IS RECEIVED, AN ERROR IS SENT
            echo ("1");
        }
    }
} else {
    //IF DATA IS NOT RECEIVED PROPERLY
    echo ("1");
}
