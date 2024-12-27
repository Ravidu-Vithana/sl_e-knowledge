<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>

    <link rel="stylesheet" href="semantic.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

</head>

<body class="bstu">

    <div class="ui container">
        <div class="ui row">
            <div class="ui grid">
                <div class="ui fourteen wide column centered">

                    <h1 class="ui header centered stuTitle">Student Login</h1>

                </div>
            </div>
        </div>
        <div class="ui row">
            <div class="ui centered grid">
                <div class="ui two column row">
                    <div class="eight wide computer and tablet only column s_imageDiv"></div>
                    <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                        <div class="ui row">

                            <?php

                            $uname = "";
                            $password = "";

                            if (isset($_COOKIE["stu"])) {
                                $uname = $_COOKIE["stu"];
                            }

                            if (isset($_COOKIE["stp"])) {
                                $password = $_COOKIE["stp"];
                            }

                            ?>

                            <p class="ui hidden message" id="errMsg"></p>

                            <div class="ui center aligned sixteen wide column">
                                <p class="username">Username</p>
                            </div>
                            <div class="ui sixteen wide column">
                                <div class="ui fluid input">
                                    <input type="text" id="uname" value="<?php echo ($uname); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="ui row">
                            <div class="ui center aligned sixteen wide column">
                                <p class="password">Password</p>
                            </div>
                            <div class="ui sixteen wide column">
                                <div class="ui fluid input">
                                    <input type="password" id="password" value="<?php echo ($password); ?>">
                                    <button class="ui button" onclick="changeViewPw();"><i class="eye slash outline icon" id="eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="ui row">
                            <div class="ui checkbox rememberMeDiv">
                                <input type="checkbox" id="rememberMe" <?php if (isset($_COOKIE["stp"])) {
                                                                        ?> checked <?php
                                                                                } ?>>
                                <label for="rememberMe" class="remLabel">Remember Me</label>
                            </div>
                        </div>
                        <div class="ui row signInBtnDiv">
                            <button class="ui primary fluid button" onclick="signIn('1');">
                                Sign In
                            </button>
                        </div>
                        <div class="ui row">
                            <div>
                                <a class="forgotPasswordstu" href="forgotPassword.php">Forgot Password?</a>
                            </div>
                            <div>
                                <a class="anotherUser" href="index.php">Another User?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- verification modal -->
    <div class="ui modal" id="verification_modal">
        <i class="close icon"></i>
        <div class="header">
            Student Verification
        </div>
        <div class="content">
            <p>Please enter the verification code sent by the Academic Officer.</p>
            <div class="ui grid">
                <div class="ui eight wide computer and sixteen wide mobile column">
                    <div class="ui fluid input">
                        <input type="text" placeholder="Verification Code" id="vCode">
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Cancel
            </div>
            <div class="ui positive right labeled icon button" onclick="Verification('1');">
                Verify!
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>
    <!-- verification modal -->

    <!-- Trial Modal -->
    <div class="ui modal" id="trial">
        <i class="close icon"></i>
        <div class="header" id="topic">
            <!-- content -->
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="ui row" id="content" style="min-height: 5rem;">
                    <span id="msg">
                        <!-- content -->
                    </span>
                </div>
            </div>
        </div>
        <div class="actions">
            <span id="err"></span>
            <div class="ui black deny button" id="closeButton">
                Close
            </div>
        </div>
    </div>
    <!-- Trial Modal -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js"></script>
    <script src="script.js"></script>
</body>

</html>