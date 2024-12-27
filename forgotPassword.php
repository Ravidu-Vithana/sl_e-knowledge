<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Forgot Password</title>

    <link rel="stylesheet" href="semantic.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

</head>

<body class="fPwBg">

    <div class="ui container">
        <h1 class="ui centered header fPTitle">Reset Your Password</h1>
        <div class="ui centered grid">
            <div class="ui eight wide computer and twelve wide mobile grid column fpField">
                <div class="ui sixteen wide column">
                    <p class="fptxt">Enter your email</p>
                    <div class="ui input fluid">
                        <input type="text" placeholder="email" id="email">
                    </div>
                </div>
                <div class="ui sixteen wide mobile and eight wide computer column">
                    <p class="fptxt">I am a..</p>
                    <select id="acc_type" class="ui selection fluid dropdown">
                        <option value="1">Student</option>
                        <option value="2">Teacher</option>
                        <option value="3">Academic Officer</option>
                        <option value="4">Admin</option>
                    </select>
                </div>
                <p class="ui hidden message" id="errMsg"></p>
                <div id="loader"></div>
                <div class="ui centered sixteen wide mobile and eight wide computer column">
                    <button class="ui fluid primary button" onclick="fPwVerification();" id="verifyBtn">Verify</button>
                </div>
            </div>
        </div>
        <div class="ui centered grid">
            <div class="ui eight wide computer and twelve wide mobile grid column fpField">
                <div class="ui sixteen wide column">
                    <p class="fptxt">Enter the Verification Code</p>
                    <p class="fptxt2">Enter the verification code received to the above email after verifying.</p>
                    <div class="ui input fluid">
                        <input type="text" placeholder="Verification Code" id="vcode">
                    </div>
                </div>
                <div class="ui row">
                    <div class="ui sixteen wide column">
                        <p class="fptxt2">Enter the new password.</p>
                    </div>
                    <div class="ui sixteen wide mobile and eight wide computer column">
                        <div class="ui input fluid">
                            <input type="text" placeholder="New Password" id="newpw">
                        </div>
                    </div>
                    <div class="ui sixteen wide mobile and eight wide computer column">
                        <div class="ui input fluid">
                            <input type="text" placeholder="Confirm Password" id="conpw">
                        </div>
                    </div>
                </div>
                <p class="ui hidden message" id="errMsg2"></p>
                <div class="ui centered sixteen wide mobile and eight wide computer column">
                    <button class="ui fluid primary disabled button" id="resetBtn" onclick="resetPw();">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js"></script>
    <script src="script.js"></script>
</body>

</html>