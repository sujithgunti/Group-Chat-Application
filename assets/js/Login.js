if (localStorage.getItem("token")) {
    location.href = "./dashboard.html";
}

let params = new URLSearchParams(location.search);
if (params.get("error")) {
    alert(params.get("error"));
    window.history.replaceState(null, "", window.location.pathname);
}

$(document).ready(function(){
    const email=$("#email");
    const errorEmail=$("#errorEmail");
    const password=$("#password");
    const errorPassword=$("#errorPassword");
    const emailPattern=/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
    const passwordPattern=/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}/;
    email.on('input',function(){
        if(!emailPattern.test(email.val())){
            email.addClass("is-invalid");
            errorEmail.html("<p>Email must be in abc@xyz.com</p>");
            errorEmail.addClass("text-danger is-invalid");
        }
        else{
            email.removeClass("is-invalid");
            email.addClass("is-valid");
            errorEmail.addClass("d-none");
        }
    
    })
    password.on('input',function(){
        if(!passwordPattern.test(password.val())){
            password.addClass("is-invalid");
            errorPassword.html("<p>Password must contain one captial letter ,special character and digits");
            errorPassword.addClass("text-danger is-invalid");
        }
        else{
            password.removeClass("is-invalid");
            password.addClass("is-valid");
            errorPassword.addClass("d-none");
        }   
    
    })
    
})

function login() {
    let email = $("#email").val();
    let password = $("#password").val();

    // Do the validation

    $.ajax({
        url: "http://localhost/codeschool/ChatGroup/api/Login.php",
        method: "POST",
        data: {
            email,
            password,
        },
        success: (response) => {
            response = JSON.parse(response);
            if (!response.status) {
                Swal.fire({
                
                    icon: "error",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                  });
                return false;
            }
            localStorage.setItem("token", response.data.token);
            location.href = "./dashboard.html";
        },
        error: (response) => {
            console.log(response);
        },
    });
}


