if (localStorage.getItem("token")) {
  location.href = "./dashboard.html";
}

let namePattern = /^[a-zA-Z0-9_]{3,}$/;
let emailPatterns = /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
let passwordPatterns = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-+.])/;
let name = $("#name");
let email = $("#userEmail");
let password = $("#UserPassword");
let confirmPassword = $("#confirmPassword");
name.on("input", function () {
  if (!namePattern.test(name.val())) {
    $("#errorName").html(
      "<p class='text-danger '>The name should be valid</p>"
    );
    name.addClass("is-invalid");
  } else if (namePattern.test(name.val())) {
    name.removeClass("is-invalid");
    $("#errorName").html("");
    name.addClass("is-valid");
  }
});

email.on("input", function () {
  if (!emailPatterns.test(email.val())) {
    $("#errorEmail").html(
      "<span class='text-danger '>The email should be valid</span>"
    );

    email.addClass("is-invalid");
  } else if (emailPatterns.test(email.val())) {
    email.removeClass("is-invalid");
    email.addClass("is-valid");
    $("#errorEmail").html("");
  }
});
password.on("input", function () {
  if (!passwordPatterns.test(password.val())) {
    $("#errorPassword").html(
      "<span class='text-danger '>The password should at least contain one uppercase one lowercase and one special character</span>"
    );

    password.addClass("is-invalid");
  } else if (passwordPatterns.test(password.val())) {
    password.removeClass("is-invalid");
    $("#errorPassword").html("");
    password.addClass("is-valid");
  }
});
confirmPassword.on("input", function () {
  if (confirmPassword.val() != password.val()) {
    $("#errorConfirmPassword").html(
      "<span class='text-danger '>The confirm password should match the password</span>"
    );
    confirmPassword.addClass("is-invalid");
  } else if (confirmPassword.val() == password.val()) {
    confirmPassword.removeClass("is-invalid");
    $("#errorConfirmPassword").html("");
    confirmPassword.addClass("is-valid");
  }
});

function register() {
  let name = $("#name").val();
  let email = $("#userEmail").val();
  let password = $("#UserPassword").val();
  let confirmPassword = $("#confirmPassword").val();
  let DOB = $("#DOB").val();
  console.log(name, email, password, confirmPassword, DOB);

  $.ajax({
    url: "http://localhost/codeschool/ChatGroup/api/Register.php",
    method: "POST",
    data: {
      name,
      email,
      password,
      confirmPassword,
      DOB,
    },
    success: (response) => {
      response = JSON.parse(response);
      if (!response.status) {
        Swal.fire({
          icon: "error",
          title: response.message,
          showConfirmButton: false,
          timer: 1500,
        });
        return false;
      }
      location.href = "./login.html";
    },
    error: (response) => {
      console.log(response);
    },
  });
}
