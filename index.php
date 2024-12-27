<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SL e-knowledge</title>

    <link rel="stylesheet" href="semantic.css">
    <link rel="stylesheet" href="style.css" />
</head>

<body class="b">

    <div class="ui container">
        <div class="ui row">
            <div class="ui grid">
                <div class="ui fourteen wide column centered welcomeTitleDiv">

                    <h1 class="ui header centered welcomeTitle">Hi&excl; Welcome to SL <span class="welcomeTitle e">e&dash;knowledge&excl;</span></h1>

                </div>
            </div>
        </div>
        <div class="ui row">
            <div class="ui grid padded">
                <div class="ui sixteen column">
                    <h2 class="ui header iam">I am...</h2>
                </div>
            </div>
        </div>
        <div class="ui row userMain">
            <div class="ui column padded userdiv" id="student" onclick="window.location = 'student_login.php'">
                <p class="userText"><i class="bi bi-pencil-fill"></i> A Student</p>
            </div>
            <div class="ui column padded userdiv" id="teacher" onclick="window.location = 'teacher_login.php'">
                <p class="userText"><i class="bi bi-pen-fill"></i> A Teacher</p>
            </div>
            <div class="ui column padded userdiv" id="officer" onclick="window.location = 'academic_officer_login.php'">
                <p class="userText"><i class="bi bi-person-lines-fill"></i> An Academic Officer</p>
            </div>
            <div class="ui column padded userdiv" id="admin" onclick="window.location = 'admin_login.php'">
                <p class="userText"><i class="bi bi-person-fill-gear"></i> An Admin</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js"></script>
    <script src="script.js"></script>
</body>

</html>