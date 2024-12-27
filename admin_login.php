<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link rel="stylesheet" href="semantic.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

</head>

<body class="badm">

    <div class="ui container">
        <div class="ui row">
            <div class="ui grid">
                <div class="ui fourteen wide column centered">

                    <h1 class="ui header centered adTitle">Admin Login</h1>

                </div>
            </div>
        </div>
        <div class="ui row">
            <div class="ui centered grid">
                <div class="ui two column row">
                    <div class="eight wide computer and tablet only column ad_imageDiv"></div>
                    <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                        <div class="ui row">

                            <?php

                            $uname = "";
                            $password = "";

                            if (isset($_COOKIE["adu"])) {
                                $uname = $_COOKIE["adu"];
                            }

                            if (isset($_COOKIE["adp"])) {
                                $password = $_COOKIE["adp"];
                            }

                            ?>

                            <p class="ui hidden message" id="errMsg"></p>

                            <div class="ui center aligned sixteen wide column">
                                <p class="username">Username</p>
                            </div>
                            <div class="ui sixteen wide column">
                                <div class="ui fluid input">
                                    <input type="text" id="uname" value="<?php echo ($uname) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="ui row">
                            <div class="ui center aligned sixteen wide column">
                                <p class="password">Password</p>
                            </div>
                            <div class="ui sixteen wide column">
                                <div class="ui fluid input">
                                    <input type="password" id="password" value="<?php echo ($password) ?>">
                                    <button class="ui button" onclick="changeViewPw();"><i class="eye slash outline icon" id="eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="ui row">
                            <div class="ui checkbox rememberMeDiv">
                                <input type="checkbox" id="rememberMe" <?php if (isset($_COOKIE["adp"])) {
                                                                        ?> checked <?php
                                                                                } ?>>
                                <label for="rememberMe" class="remLabel">Remember Me</label>
                            </div>
                        </div>
                        <div class="ui row signInBtnDiv">
                            <button class="ui red fluid button" onclick="signIn('4');">
                                Sign In
                            </button>
                        </div>
                        <div class="ui row">
                            <div>
                                <a class="forgotPasswordad" href="forgotPassword.php">Forgot Password?</a>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js"></script>
    <script src="script.js"></script>
</body>

</html>