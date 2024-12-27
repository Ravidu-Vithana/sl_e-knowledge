<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//REQUIRING THE OTHER ESSENTIALS
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if (isset($_GET["email"]) && isset($_GET["acc_type"])) {
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $email = $_GET["email"];
    $acc_type = $_GET["acc_type"];
    //END STORING DATA

    //START VALIDATING DATA
    if (empty($email)) {
        echo ("Please enter the email!");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email");
    } else if (strlen($email) > 100) {
        echo ("Email must have be less than 100 characters!");
    } else {
        //END VALIDATING DATA

        //CHECKING THE ACCOUNT TYPE THAT THE VERIFICATION IS DONE
        if ($acc_type == 1) {
            //IF THE ACCOUNT TYPE IS STUDENT

            //SELECTING THE STUDENT FROM THE DATABASE ACCORDING TO THE RECEIVED EMAIL. MEANWHILE CHECKING WHETHER THE STUDENT IS VERIFIED AND ACTIVE
            $student_rs = Database::search("SELECT * FROM `student` WHERE `email` = '" . $email . "' AND `verified` = '1' AND `status` = '1'");
            $student_num = $student_rs->num_rows;

            if ($student_num == 1) {
                //IF A VERIFIED AND ACTIVE STUDENT EXISTS FOR THE RECEIVED EMAIL

                //START SENDING EMAIL WITH THE VERIFICATION CODE
                $code = uniqid();

                Database::iud("UPDATE `student` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");

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
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'SL e-Knowledge Forgot Password Verification Code';
                $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Academic Officer.</span>';
                $mail->Body    = $bodyContent;
                //END OF SENDING EMAIL

                if (!$mail->send()) {
                    //IF THE EMAIL IS NOT SENT PROPERLY
                    echo ("Verification Code sending failed. Please try again");
                } else {
                    //IF THE EMAIL IS SENT PROPERLY
                    echo ("success");
                }
            } else {
                //IF A VERIFIED ACTIVE USER DOESN'T EXIST FOR THE RECEIVED EMAIL
                echo ("User doesn't exist! Incase your entered details are correct, you might have been blocked or still unverified. Please verify your account first by signing in from the credentials sent into your email.");
            }
        } else if ($acc_type == 2) {
            //IF THE ACCOUNT TYPE IS TEACHER

            //CHECKING FOR A VERIFIED ACTIVE TEACHER FOR THE RECEIVED EMAIL
            $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `email` = '" . $email . "' AND `verified` = '1'");
            $teacher_num = $teacher_rs->num_rows;

            if ($teacher_num == 1) {
                //IF A VERIFIED ACTIVE TEACHER EXISTS FOR THE GIVEN EMAIL

                //START SENDING THE VERIFICATION CODE EMAIL
                $code = uniqid();

                Database::iud("UPDATE `teacher` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");

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
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'SL e-Knowledge Forgot Password Verification Code';
                $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Admin.</span>';
                $mail->Body    = $bodyContent;
                //END SENDING THE EMAIL

                if (!$mail->send()) {
                    //IF THE EMAIL IS NOT SENT PROPERLY
                    echo ("Verification Code sending failed. Please try again");
                } else {
                    //IF THE EMAIL IS SENT PROPERLY
                    echo ("success");
                }
            } else {
                //IF A VERIFIED ACTIVE TEACHER DOESN'T EXIST FOR THE GIVEN EMAIL
                echo ("User doesn't exist!");
            }
        } else if ($acc_type == 3) {
            //IF THE ACCOUNT TYPE IS ACADEMIC OFFICER

            //CHECKING FOR A VERIFIED ACTIVE ACADEMIC OFFICER ACCORDING TO THE RECEIVED EMAIL
            $officer_rs = Database::search("SELECT * FROM `academic_officer` WHERE `email` = '" . $email . "' AND `verified` = '1'");
            $officer_num = $officer_rs->num_rows;

            if ($officer_num == 1) {
                //IF A VERIFIED ACTIVE ACADEMIC OFFICER FOR THE RECEIVED EMAIL EXISTS

                //START SENDING EMAIL WITH THE VERIFICATION CODE
                $code = uniqid();

                Database::iud("UPDATE `academic_officer` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");

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
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'SL e-Knowledge Forgot Password Verification Code';
                $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Please contact the Admin.</span>';
                $mail->Body    = $bodyContent;
                //END SENDING EMAIL

                if (!$mail->send()) {
                    //IF THE EMAIL IS NOT SENT
                    echo ("Verification Code sending failed. Please try again");
                } else {
                    //IF THE EMAIL IS SENT
                    echo ("success");
                }
            } else {
                //IF A VERIFIED ACTIVE ACADEMIC OFFICER FOR THE GIVEN EMAIL DOESN'T EXIST
                echo ("User doesn't exist!");
            }
        } else if ($acc_type == 4) {
            //IF THE ACCOUNT TYPE IS ADMIN

            //CHECKING FOR A ADMIN ACCORDING TO THE RECEIVED EMAIL
            $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $email . "'");
            $admin_num = $admin_rs->num_rows;

            if ($admin_num == 1) {
                //IF A ADMIN FOR THE RECEIVED EMAIL EXISTS

                //START SENDING THE EMAIL WITH THE VERIFICATION CODE
                $code = uniqid();

                Database::iud("UPDATE `admin` SET `verification_code` = '" . $code . "' 
                WHERE `email` = '" . $email . "'");

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
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'SL e-Knowledge Forgot Password Verification Code';
                $bodyContent = '<span>Your Verification code is <br/>' . $code . '<br/>. Please donot share this with anyone. If you did not request this somebody might be trying to log into your account. Reset your password immediately.</span>';
                $mail->Body    = $bodyContent;
                //END OF SENDING THE EMAIL

                if (!$mail->send()) {
                    //IF THE EMAIL IS NOT SENT
                    echo ("Verification Code sending failed. Please try again");
                } else {
                    //IF THE EMAIL IS SENT
                    echo ("success");
                }
                
            } else {
                //IF A ADMIN DOESN'T EXIST FOR THE RECEIVED EMAIL
                echo ("User doesn't exist!");
            }
        }
    }
} else {
    //IF THE DATA IS NOT RECEIVED PROPERLY
    echo ("1");
}
