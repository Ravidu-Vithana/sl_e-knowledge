$('.ui.dropdown')
  .dropdown()
  ;

$(document).ready(function () {
  $('.tabular.menu .item').tab();
});

function changeViewPw() {
  var eye = document.getElementById("eye");
  var password = document.getElementById("password");

  if (password.type == "password") {

    password.type = "text";
    eye.classList = "eye icon";

  } else if (password.type == "text") {

    password.type = "password";
    eye.classList = "eye slash outline icon";

  }

}

function signIn(x) {
  var username = document.getElementById("uname").value;
  var password = document.getElementById("password").value;
  var rememberMe = document.getElementById("rememberMe");
  var err = document.getElementById("errMsg");
  var acc_type = x;

  var f = new FormData();
  f.append("u", username);
  f.append("p", password);
  f.append("r", rememberMe.checked);
  f.append("acc_type", acc_type);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;

      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == 2) {
        VerificationModal();
      } else if (t == 3) {
        trialHasModal();
      } else if (t == 4) {
        trialEndModal();
      } else if (t == "success") {

        if (acc_type == 1) {
          window.location = "student_portal.php";
        } else if (acc_type == 2) {
          window.location = "teacher_portal.php";
        } else if (acc_type == 3) {
          window.location = "academic_officer_portal.php";
        } else if (acc_type == 4) {
          window.location = "admin_portal.php";
        } else {
          alert("Something went wrong. Please try again.");
          window.location.reload();
        }

      } else {
        err.classList = "ui floating red message";
        err.innerHTML = t;
        setTimeout(function () { err.classList = "ui hidden message"; err.innerHTML = ""; }, 5000);
      }

    }
  };

  r.open("POST", "signInProcess.php", true);
  r.send(f);

}

function VerificationModal() {
  $('#verification_modal')
    .modal('setting', 'closable', false)
    .modal('show')
    ;
}

function Verification(x) {

  var vcode = document.getElementById("vCode").value;
  var err = document.getElementById("errMsg");
  var acc_type = x;

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;

      if (t == 1) {
        alert("Something went wrong. Please try again");

        $('#verification_modal')
          .modal('hide')
          ;

        window.location.reload();

      } else if (t == "success") {
        $('#verification_modal')
          .modal('hide')
          ;

        err.innerHTML = "You are now verified <i class='paper plane icon'></i>";
        err.classList = "ui floating green message";
        setTimeout(function () { err.classList = "ui hidden message"; err.innerHTML = "" }, 5000);

      } else {

        err.innerHTML = t;
        err.classList = "ui floating red message";
        setTimeout(function () { err.classList = "ui hidden message"; err.innerHTML = "" }, 5000);

      }
    }
  };

  r.open("GET", "verificationProcess.php?vcode=" + vcode + "&acc_type=" + acc_type, true);
  r.send();

}

function fPwVerification() {
  var email = document.getElementById("email");
  var acc_type = document.getElementById("acc_type");
  var verifyBtn = document.getElementById("verifyBtn");
  var resetBtn = document.getElementById("resetBtn");
  var err = document.getElementById("errMsg");
  var loader = document.getElementById("loader");

  err.innerHTML = "Please wait...";
  err.classList = "ui floating green message";
  loader.classList = "ui active inline centered loader";

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;

      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == "success") {
        loader.classList = "";
        err.classList = "ui floating green message";
        err.innerHTML = "Verification Code Sent!";
        verifyBtn.innerHTML = "Verified <i class='paper plane icon'></i>";
        verifyBtn.classList = "ui fluid positive disabled button";
        email.setAttribute("readonly", true);
        acc_type.setAttribute("disabled", "");
        resetBtn.classList = "ui fluid primary button";
      } else {
        err.innerHTML = t;
        loader.classList = "";
        err.classList = "ui floating red message";
        setTimeout(function () { err.classList = "ui hidden message"; err.innerHTML = "" }, 5000);
      }

    }
  };

  r.open("GET", "forgotPasswordVerification.php?email=" + email.value + "&acc_type=" + acc_type.value, true);
  r.send();

}

function resetPw() {

  var email = document.getElementById("email").value;
  var acc_type = document.getElementById("acc_type").value;
  var vcode = document.getElementById("vcode").value;
  var newpw = document.getElementById("newpw").value;
  var conpw = document.getElementById("conpw").value;
  var err2 = document.getElementById("errMsg2");
  var resetBtn = document.getElementById("resetBtn");

  var f = new FormData();
  f.append("email", email);
  f.append("acc_type", acc_type);
  f.append("vcode", vcode);
  f.append("newpw", newpw);
  f.append("conpw", conpw);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;

      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == "success") {
        resetBtn.innerHTML = "Password Changed";
        resetBtn.classList = "ui fluid positive disabled button";
        err2.innerHTML = "Redirecting...";
        err2.classList = "ui floating green message";
        setTimeout(function () {
          if (acc_type == 1) {
            window.location = "student_login.php";
          } else if (acc_type == 2) {
            window.location = "teacher_login.php";
          } else if (acc_type == 3) {
            window.location = "academic_officer_login.php";
          } else if (acc_type == 4) {
            window.location = "admin_login.php";
          }
        }, 2000);

      } else {
        err2.innerHTML = t;
        err2.classList = "ui floating red message";
        setTimeout(function () { err2.classList = "ui hidden message"; err2.innerHTML = "" }, 5000);
      }

    }
  };

  r.open("POST", "resetPasswordProcess.php", true);
  r.send(f);

}

function signOut(x) {

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {

        if (x == 1) {
          window.location = "student_login.php";
        } else if (x == 2) {
          window.location = "teacher_login.php";
        } else if (x == 3) {
          window.location = "academic_officer_login.php";
        } else if (x == 4) {
          window.location = "admin_login.php";
        } else {
          window.location = "index.php";
        }

      } else {
        alert(t)
      }
    }
  };

  r.open("GET", "signOutProcess.php?acc_type=" + x, true);
  r.send();

}

function updateProfileModal() {

  $('#updateProfileModal')
    .modal({
      onHidden: function () { window.location.reload(); }
    })
    .modal('show');

}

function viewImage() {
  var image = document.getElementById("imageUploader");

  image.onchange = function () {
    var file_count = image.files.length;

    if (file_count == 1) {
      var file = image.files[0];
      var url = window.URL.createObjectURL(file);

      document.getElementById("proImg").src = url;

      updateAgain();

    }

  }

}

var formdata;

function updateProfile(x, img_st) {

  var image = document.getElementById("imageUploader");
  var initials = document.getElementById("initials").value;
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var gender = document.getElementById("gender").value;
  var email = document.getElementById("email").value;
  var line1 = document.getElementById("line1").value;
  var line2 = document.getElementById("line2").value;
  var city = document.getElementById("city").value;
  var district = document.getElementById("district").value;
  var mobile = document.getElementById("mobile").value;
  var acc_type = x;

  formdata = new FormData();
  formdata.append("initials", initials);
  formdata.append("fname", fname);
  formdata.append("lname", lname);
  formdata.append("gender", gender);
  formdata.append("email", email);
  formdata.append("line1", line1);
  formdata.append("line2", line2);
  formdata.append("city", city);
  formdata.append("district", district);
  formdata.append("mobile", mobile);
  formdata.append("acc_type", acc_type);

  var file_count = image.files.length;

  if (file_count == 1) {

    formdata.append("image", image.files[0]);

    updateProfileProcess();

  } else {

    if (img_st == 0) {

      var confirmation = confirm("Are you sure you don't want to update your Profile Image");

      if (confirmation) {

        updateProfileProcess();

      }

    } else {

      updateProfileProcess();

    }

  }

}

function updateProfileProcess() {

  var saveBtn = document.getElementById("saveBtn");
  var okBtn = document.getElementById("okBtn");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        saveBtn.innerHTML = "Updated";
        saveBtn.classList = "ui blue disabled button";
        okBtn.classList = "ui positive button";
      } else if (t == "Address details incomplete. Line 1 cannot be empty.") {
        saveBtn.innerHTML = "Updated";
        saveBtn.classList = "ui blue disabled button";
        okBtn.classList = "ui positive button";
        alert(t);
      } else if (t == "Address details incomplete. Please select the city.") {
        saveBtn.innerHTML = "Updated";
        saveBtn.classList = "ui blue disabled button";
        okBtn.classList = "ui positive button";
        alert(t);
      } else if (t == "Address details incomplete. Please select the district.") {
        saveBtn.innerHTML = "Updated";
        saveBtn.classList = "ui blue disabled button";
        okBtn.classList = "ui positive button";
        alert(t);
      } else if (t == "Image update failed. Image type is invalid!") {
        saveBtn.innerHTML = "Updated";
        saveBtn.classList = "ui blue disabled button";
        okBtn.classList = "ui positive button";
        alert(t);
      } else {
        alert(t);
      }
    }
  };

  r.open("POST", "updateProfileProcess.php", true);
  r.send(formdata);
}

function updateAgain() {

  var saveBtn = document.getElementById("saveBtn");
  var okBtn = document.getElementById("okBtn");

  saveBtn.innerHTML = "Save";
  saveBtn.classList = "ui blue button";
  okBtn.classList = "ui positive disabled button";

}

function addTeacherModal() {
  $('#addTeacherModal')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsTModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;
}

function addTeacher() {

  var initials = document.getElementById("initialsT").value;
  var fname = document.getElementById("fnameT").value;
  var lname = document.getElementById("lnameT").value;
  var gender = document.getElementById("genderT").value;
  var email = document.getElementById("emailT").value;
  var username = document.getElementById("usernameT").value;
  var password = document.getElementById("passwordT").value;
  var mobile = document.getElementById("mobileT").value;
  var waitmsg = document.getElementById("waitT");

  waitmsg.innerHTML = "Please wait...";

  var f = new FormData();
  f.append("initials", initials);
  f.append("fname", fname);
  f.append("lname", lname);
  f.append("gender", gender);
  f.append("email", email);
  f.append("username", username);
  f.append("password", password);
  f.append("mobile", mobile);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {

        waitmsg.innerHTML = "";
        alert("Invitation sent successfully!");
        loadUsersInAdmin();
        clearFieldsTModal();

      } else {
        waitmsg.innerHTML = "";
        alert(t);
      }
    }
  };

  r.open("POST", "addTeacherProcess.php", true);
  r.send(f);

}

function clearFieldsTModal() {

  document.getElementById("initialsT").value = "";
  document.getElementById("fnameT").value = "";
  document.getElementById("lnameT").value = "";
  document.getElementById("genderT").value = "";
  document.getElementById("emailT").value = "";
  document.getElementById("usernameT").value = "";
  document.getElementById("passwordT").value = "";
  document.getElementById("mobileT").value = "";

}

function addOfficerModal() {
  $('#addOfficerModal')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsAcModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;
}

function addOfficer() {

  var initials = document.getElementById("initialsAc").value;
  var fname = document.getElementById("fnameAc").value;
  var lname = document.getElementById("lnameAc").value;
  var gender = document.getElementById("genderAc").value;
  var email = document.getElementById("emailAc").value;
  var username = document.getElementById("usernameAc").value;
  var password = document.getElementById("passwordAc").value;
  var mobile = document.getElementById("mobileAc").value;
  var waitmsg = document.getElementById("waitAc");

  waitmsg.innerHTML = "Please wait...";

  var f = new FormData();
  f.append("initials", initials);
  f.append("fname", fname);
  f.append("lname", lname);
  f.append("gender", gender);
  f.append("email", email);
  f.append("username", username);
  f.append("password", password);
  f.append("mobile", mobile);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {

        waitmsg.innerHTML = "";
        alert("Invitation sent successfully!");
        loadUsersInAdmin();
        clearFieldsAcModal();

      } else {
        waitmsg.innerHTML = "";
        alert(t);
      }
    }
  };

  r.open("POST", "addOfficerProcess.php", true);
  r.send(f);

}

function clearFieldsAcModal() {
  document.getElementById("initialsAc").value = "";
  document.getElementById("fnameAc").value = "";
  document.getElementById("lnameAc").value = "";
  document.getElementById("genderAc").value = "";
  document.getElementById("emailAc").value = "";
  document.getElementById("usernameAc").value = "";
  document.getElementById("passwordAc").value = "";
  document.getElementById("mobileAc").value = "";
}

function sentInvModalAd() {
  $('#sentInvitations')
    .modal('setting', 'closable', false)
    .modal('show')
    ;

  loadInvAd();

}

function loadInvAd() {
  var load = document.getElementById("loadInv");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      load.innerHTML = t;
    }
  };

  r.open("GET", "loadAdminInvitationsProcess.php", true);
  r.send();

}

function addStudentModal() {

  $('#addStudentModal')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsStModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;

}

function addStudent() {

  var initials = document.getElementById("initialsS").value;
  var fname = document.getElementById("fnameS").value;
  var lname = document.getElementById("lnameS").value;
  var gender = document.getElementById("genderS").value;
  var email = document.getElementById("emailS").value;
  var username = document.getElementById("usernameS").value;
  var password = document.getElementById("passwordS").value;
  var mobile = document.getElementById("mobileS").value;
  var grade = document.getElementById("gradeS").value;
  var err = document.getElementById("errS");

  err.classList = "ui green message";
  err.innerHTML = "Please wait...";

  var f = new FormData();
  f.append("initials", initials);
  f.append("fname", fname);
  f.append("lname", lname);
  f.append("gender", gender);
  f.append("email", email);
  f.append("username", username);
  f.append("password", password);
  f.append("mobile", mobile);
  f.append("grade", grade);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        err.classList = "ui green message";
        err.innerHTML = "Invitation sent successfully!";
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        clearFieldsStModal();

      } else {
        err.classList = "ui red message";
        err.innerHTML = t;
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      }
    }
  };

  r.open("POST", "addStudentProcess.php", true);
  r.send(f);

}

function clearFieldsStModal() {

  document.getElementById("initialsS").value = "";
  document.getElementById("fnameS").value = "";
  document.getElementById("lnameS").value = "";
  document.getElementById("genderS").value = "";
  document.getElementById("emailS").value = "";
  document.getElementById("usernameS").value = "";
  document.getElementById("passwordS").value = "";
  document.getElementById("mobileS").value = "";

}

function sentInvModalAc() {
  $('#sentRegistrations')
    .modal('setting', 'closable', false)
    .modal('show')
    ;

  loadRegStu();
}

function loadRegStu() {

  var load = document.getElementById("loadReg");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      load.innerHTML = t;
    }
  };

  r.open("GET", "loadOfficerRegistrationsProcess.php", true);
  r.send();

}

function upAsModal() {

  $('#uploadAssignment')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsAsModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;

}

function loadSubAsModal() {

  var grade = document.getElementById("gradeAs");
  var subject = document.getElementById("subjectAs");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      subject.innerHTML = t;
    }
  };

  r.open("GET", "loadSubProcess.php?grade=" + grade.value, true);
  r.send();

}

function viewAs() {
  var input = document.getElementById("uploaderAs");

  input.onchange = function () {
    var file_count = input.files.length;

    if (file_count == 1) {

      var file = input.files[0];
      document.getElementById("fileAs").value = file["name"];

    }

  }

}

function uploadAs() {
  var title = document.getElementById("titleAs").value;
  var grade = document.getElementById("gradeAs").value;
  var subject = document.getElementById("subjectAs").value;
  var input = document.getElementById("uploaderAs");
  var err = document.getElementById("errMsgAs");

  var f = new FormData();
  f.append("title", title);
  f.append("grade", grade);
  f.append("subject", subject);
  f.append("file", input.files[0]);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        err.classList = "ui green message";
        err.innerHTML = "Assignment Uploaded!";
        loadTeacherFiles();
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        clearFieldsAsModal();

      } else if (t == 1) {
        alert("Something went wrong. Please try again");
        window.location.reload();
      } else {
        err.classList = "ui red message";
        err.innerHTML = t;
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      }
    }
  };

  r.open("POST", "uploadAssignmentProcess.php", true);
  r.send(f);

}

function clearFieldsAsModal() {
  document.getElementById("titleAs").value = "";
  document.getElementById("fileAs").value = "";
  document.getElementById("gradeAs").value = "0";
  loadSubAsModal();
}

function upNModal() {

  $('#uploadNote')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsNModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;

}

function loadSubNModal() {
  var grade = document.getElementById("gradeN");
  var subject = document.getElementById("subjectN");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      subject.innerHTML = t;
    }
  };

  r.open("GET", "loadSubProcess.php?grade=" + grade.value, true);
  r.send();

}

function viewN() {
  var input = document.getElementById("uploaderN");

  input.onchange = function () {
    var file_count = input.files.length;

    if (file_count == 1) {

      var file = input.files[0];
      document.getElementById("fileN").value = file["name"];

    }

  }
}

function uploadN() {
  var title = document.getElementById("titleN").value;
  var grade = document.getElementById("gradeN").value;
  var subject = document.getElementById("subjectN").value;
  var input = document.getElementById("uploaderN");
  var err = document.getElementById("errMsgN");

  var f = new FormData();
  f.append("title", title);
  f.append("grade", grade);
  f.append("subject", subject);
  f.append("file", input.files[0]);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        err.classList = "ui green message";
        err.innerHTML = "Note Uploaded!";
        loadTeacherFiles();
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        clearFieldsNModal();

      } else if (t == 1) {
        alert("Something went wrong. Please try again");
        window.location.reload();
      } else {
        err.classList = "ui red message";
        err.innerHTML = t;
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      }
    }
  };

  r.open("POST", "uploadNoteProcess.php", true);
  r.send(f);

}

function clearFieldsNModal() {
  document.getElementById("titleN").value = "";
  document.getElementById("fileN").value = "";
  document.getElementById("gradeN").value = "0";
  loadSubNModal();
}

function upMarksModal() {

  $('#uploadMarks')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onHidden: function () {
        clearFieldsMarksModal();
      },
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;

}

function loadStudentandAssignment() {
  loadStudent();
  loadAssignment();
}

function loadStudent() {
  var grade = document.getElementById("gradeM");
  var student = document.getElementById("student");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      student.innerHTML = t;
    }
  };

  r.open("GET", "loadStudentProcess.php?grade=" + grade.value, true);
  r.send();

}

function loadAssignment() {
  var grade = document.getElementById("gradeM");
  var assignment = document.getElementById("assignment");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      assignment.innerHTML = t;
    }
  };

  r.open("GET", "loadAssignmentProcess.php?grade=" + grade.value, true);
  r.send();

}

function uploadMarks() {
  var marks = document.getElementById("marks").value;
  var grade = document.getElementById("gradeM").value;
  var student = document.getElementById("student").value;
  var assignment = document.getElementById("assignment").value;
  var err = document.getElementById("errMsgMarks");

  var f = new FormData();
  f.append("marks", marks);
  f.append("grade", grade);
  f.append("student", student);
  f.append("assignment", assignment);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        err.classList = "ui green message";
        err.innerHTML = "Marks Uploaded!";
        loadTeacherFiles();
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        clearFieldsMarksModal();

      } else if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        err.classList = "ui red message";
        err.innerHTML = t;
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      }
    }
  };

  r.open("POST", "uploadMarksProcess.php", true);
  r.send(f);

}

function clearFieldsMarksModal() {
  document.getElementById("marks").value = "";
  document.getElementById("gradeM").value = "-Select-";
  document.getElementById("student").value = "0";
  document.getElementById("assignment").value = "0";
  loadStudentnAssignment();

}

function uploadAnsModal() {
  $('#uploadAnswers')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;
}

function loadSubAnsModal() {

  var subject = document.getElementById("subjectAnsM").value;
  var assignment = document.getElementById("assignmentAns");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      assignment.innerHTML = t;
    }
  };

  r.open("GET", "loadAsAnsProcess.php?subject=" + subject, true);
  r.send();

}

function viewAnsSheet() {
  var input = document.getElementById("uploaderMarks");

  input.onchange = function () {
    var file_count = input.files.length;

    if (file_count == 1) {

      var file = input.files[0];
      document.getElementById("fileMarks").value = file["name"];

    }

  }
}

function uploadAnsSheet() {

  var assignment = document.getElementById("assignmentAns").value;
  var input = document.getElementById("uploaderMarks");
  var err = document.getElementById("errMsgAns");

  var f = new FormData();
  f.append("assignment", assignment);
  f.append("file", input.files[0]);

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == "success") {
        err.classList = "ui green message";
        err.innerHTML = "Answer Sheet Uploaded!";
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        loadStudentFiles();
        clearFieldsAnsModal();

      } else if (t == "success2") {
        err.classList = "ui green message";
        err.innerHTML = "New Answer Sheet Updated!";
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
        loadStudentFiles();
        clearFieldsAnsModal();
      } else if (t == 1) {
        alert("Something went wrong. Please try again");
        window.location.reload();
      } else {
        err.classList = "ui red message";
        err.innerHTML = t;
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      }
    }
  };

  r.open("POST", "uploadAnswersProcess.php", true);
  r.send(f);
}

function clearFieldsAnsModal() {
  document.getElementById("subjectAnsM").value = "0";
  document.getElementById("assignmentAns").value = "0";
  document.getElementById("fileMarks").value = "";
  document.getElementById("uploaderMarks").value = "";

}

function loadStudentFiles() {
  var subject = document.getElementById("subject").value;
  var title = document.getElementById("title").value;
  var assignmentView = document.getElementById("studentAssignmentView");
  var notesView = document.getElementById("studentNotesView");
  var answerSheetView = document.getElementById("studentAnswerSheetView");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        assignmentView.innerHTML = t;
      }
    }
  };

  r.open("GET", "loadStudentAssignmentsProcess.php?subject=" + subject + "&title=" + title, true);
  r.send();

  var r2 = new XMLHttpRequest();

  r2.onreadystatechange = function () {
    if (r2.readyState == 4) {
      var t = r2.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        notesView.innerHTML = t;
      }
    }
  };

  r2.open("GET", "loadStudentNotesProcess.php?subject=" + subject + "&title=" + title, true);
  r2.send();

  var r3 = new XMLHttpRequest();

  r3.onreadystatechange = function () {
    if (r3.readyState == 4) {
      var t = r3.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        answerSheetView.innerHTML = t;
      }
    }
  };

  r3.open("GET", "loadStudentAnswersProcess.php?subject=" + subject + "&title=" + title, true);
  r3.send();

}

function loadTeacherFiles() {
  var subject = document.getElementById("subject").value;
  var grade = document.getElementById("grade").value;
  var title = document.getElementById("title").value;
  var assignmentView = document.getElementById("teacherAssignmentView");
  var notesView = document.getElementById("teacherNotesView");
  var answerSheetView = document.getElementById("teacherAnswerSheetView");
  var marksView = document.getElementById("teacherMarksView");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        assignmentView.innerHTML = t;
      }
    }
  };

  r.open("GET", "loadTeacherAssignmentsProcess.php?subject=" + subject + "&title=" + title + "&grade=" + grade, true);
  r.send();

  var r2 = new XMLHttpRequest();

  r2.onreadystatechange = function () {
    if (r2.readyState == 4) {
      var t = r2.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        notesView.innerHTML = t;
      }
    }
  };

  r2.open("GET", "loadTeacherNotesProcess.php?subject=" + subject + "&title=" + title + "&grade=" + grade, true);
  r2.send();

  var r3 = new XMLHttpRequest();

  r3.onreadystatechange = function () {
    if (r3.readyState == 4) {
      var t = r3.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        answerSheetView.innerHTML = t;
      }
    }
  };

  r3.open("GET", "loadTeacherAnswersProcess.php?subject=" + subject + "&title=" + title + "&grade=" + grade, true);
  r3.send();

  var r4 = new XMLHttpRequest();

  r4.onreadystatechange = function () {
    if (r4.readyState == 4) {
      var t = r4.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        marksView.innerHTML = t;
      }
    }
  };

  r4.open("GET", "loadTeacherMarksProcess.php?subject=" + subject + "&title=" + title + "&grade=" + grade, true);
  r4.send();

}

function loadAcademicOfficerFiles() {
  var subject = document.getElementById("subject").value;
  var grade = document.getElementById("grade").value;
  var teacher = document.getElementById("teacher").value;
  var student = document.getElementById("student").value;
  var title = document.getElementById("title").value;
  var receivedView = document.getElementById("officerReceivedView");
  var sentView = document.getElementById("officerSentView");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        receivedView.innerHTML = t;
      }
    }
  };

  r.open("GET", "loadOfficerReceivedMarksProcess.php?subject=" + subject + "&grade=" + grade + "&teacher=" + teacher + "&student=" + student + "&title=" + title, true);
  r.send();

  var r2 = new XMLHttpRequest();

  r2.onreadystatechange = function () {
    if (r2.readyState == 4) {
      var t = r2.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        sentView.innerHTML = t;
      }
    }
  };

  r2.open("GET", "loadOfficerSentMarksProcess.php?subject=" + subject + "&grade=" + grade + "&teacher=" + teacher + "&student=" + student + "&title=" + title, true);
  r2.send();
}

function releaseMarks(id) {

  var confirmation;

  if (id == "all") {
    confirmation = confirm("Are you sure you want to release all marks? This cannot be undone");
  } else {
    confirmation = confirm("Do you want to release this marks? This cannot be undone");
  }

  if (confirmation) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
      if (r.readyState == 4) {
        var t = r.responseText;
        if (t == 1) {
          alert("Something went wrong. Please try again.");
          window.location.reload();
        } else if (t == "success") {
          loadAcademicOfficerFiles();
        } else {
          alert(t);
        }
      }
    };

    r.open("GET", "releaseMarksProcess.php?id=" + id, true);
    r.send();
  }

}

function loadUsersInAdmin() {
  var search = document.getElementById("search").value;
  var officerView = document.getElementById("officerView");
  var teacherView = document.getElementById("teacherView");
  var studentView = document.getElementById("studentView");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        officerView.innerHTML = t;
      }
    }
  };

  r.open("GET", "loadOfficersInAdminProcess.php?search=" + search, true);
  r.send();

  var r2 = new XMLHttpRequest();

  r2.onreadystatechange = function () {
    if (r2.readyState == 4) {
      var t = r2.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        teacherView.innerHTML = t;
      }
    }
  };

  r2.open("GET", "loadTeachersInAdminProcess.php?search=" + search, true);
  r2.send();

  var r3 = new XMLHttpRequest();

  r3.onreadystatechange = function () {
    if (r3.readyState == 4) {
      var t = r3.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        studentView.innerHTML = t;
      }
    }
  };

  r3.open("GET", "loadStudentsInAdminProcess.php?search=" + search, true);
  r3.send();

}

function deleteAssignment(id) {
  var confirmation = confirm("Are you sure you want to delete this assignment? This will also delete any answers and marks given for this assignment.");

  if (confirmation) {
    deleteFile(id, "assignment");
  }
}

function deleteNote(id) {
  var confirmation = confirm("Are you sure you want to delete this note?");

  if (confirmation) {
    deleteFile(id, "note");
  }
}

function deleteAnswer(id) {

  var confirmation = confirm("Are you sure you want to delete this answer?");

  if (confirmation) {
    deleteFile(id, "answer");
  }

}

function deleteMarks(id) {
  var confirmation = confirm("Are you sure you want to delete this marks?");

  if (confirmation) {
    deleteFile(id, "mark");
  }
}

function deleteFile(id, type) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == "success") {
        if (type == "answer") {
          loadStudentFiles();
        } else {
          loadTeacherFiles();
        }
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "deleteFileProcess.php?id=" + id + "&type=" + type, true);
  r.send();
}

function blockStudent(id) {
  blockUser(id, "student");
}

function blockTeacher(id) {
  blockUser(id, "teacher");
}

function blockOfficer(id) {
  blockUser(id, "officer");
}

function blockUser(id, type) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == "success") {
        loadUsersInAdmin();
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "blockUserProcess.php?id=" + id + "&type=" + type, true);
  r.send();
}

function gradeModal(id) {
  $('#changeGrade')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onApprove: function () {
        return false;
      }
    })
    .modal('show')
    ;

  loadChangeGrade(id);

}

function loadChangeGrade(id) {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        document.getElementById("content").innerHTML = t;
      }
    }
  };

  r.open("GET", "loadChangeGradeProcess.php?id=" + id, true);
  r.send();
}

function changeGrade() {
  var id = document.getElementById("idField").innerHTML;
  var currentGrade = document.getElementById("currentGradeField").innerHTML;
  var grade = document.getElementById("grade").value;
  var err = document.getElementById("err");

  if ((currentGrade - grade) >= 0) {
    alert("New promoting grade should be higher than the current grade!")
  } else {

    var confirmation = confirm("Are you sure you want to change the grade this student from " + currentGrade + " to " + grade + "?");

    if (confirmation) {

      var r = new XMLHttpRequest();

      r.onreadystatechange = function () {
        if (r.readyState == 4) {
          var t = r.responseText;
          if (t == 1) {
            alert("Something went wrong. Please try again.");
            window.location.reload();
          } else if (t == "success") {
            err.classList = "ui green message";
            err.innerHTML = "Grade changed succefully!";
            setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
            loadUsersInAdmin();
          }
        }
      };

      r.open("GET", "changeGradeProcess.php?id=" + id + "&new=" + grade, true);
      r.send();

    }

  }

}

function trialHasModal() {
  document.getElementById("topic").innerHTML = "Trial will end soon!";
  document.getElementById("closeButton").innerHTML = "Continue";
  document.getElementById("msg").innerHTML = "Your trial will be ending in less than a month! Please pay the portal fee to continuously use this platform";

  $('#trial')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
      onDeny: function () {
        window.location = "student_portal.php";
      },
    })
    .modal('show')
    ;

}

function trialEndModal() {
  document.getElementById("topic").innerHTML = "Trial Ended!";
  document.getElementById("closeButton").innerHTML = "OK";
  document.getElementById("msg").innerHTML = "Your free trial period ended! Please pay the portal fee to continuously use this platform";

  $('#trial')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
    })
    .modal('show')
    ;

}

var teacherID;

function assignSubjectModal(id) {
  teacherID = id;

  viewCurrentSubjects();

  $('#assignSubject')
    .modal('setting', 'closable', false)
    .modal({
      closable: false,
    })
    .modal('show')
    ;
}

function viewCurrentSubjects() {
  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else {
        document.getElementById("currentSubjectsView").innerHTML = t;
      }
    }
  };

  r.open("GET", "viewCurrentSubjectsProcess.php?id=" + teacherID, true);
  r.send();
}

function assignSubject() {

  var subject = document.getElementById("subject").value;
  var grade = document.getElementById("grade").value;
  var err = document.getElementById("errAssign");

  var r = new XMLHttpRequest();

  r.onreadystatechange = function () {
    if (r.readyState == 4) {
      var t = r.responseText;
      if (t == 1) {
        alert("Something went wrong. Please try again.");
        window.location.reload();
      } else if (t == 2) {
        err.classList = "ui red message";
        err.innerHTML = "A teacher is already assigned to this subject in this grade!";
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      } else if (t == "success") {
        viewCurrentSubjects();
        err.classList = "ui green message";
        err.innerHTML = "Teacher successfully assigned!";
        setTimeout(function () { err.innerHTML = ""; err.classList = "" }, 4000);
      } else {
        alert(t);
      }
    }
  };

  r.open("GET", "assignSubjectProcess.php?id=" + teacherID + "&grade=" + grade + "&subject=" + subject, true);
  r.send();
}