$(document).ready(function() {
    //login submit
    $("#login").submit(function(e){
        e.preventDefault();
        login();
    });
});

function login() {
    let data = $("#login").serialize();
    $("#loginScreen").prop("hidden", true);
    $("#loading").prop("hidden", false);
    $.post("php/ac/login.php", data, function(response) {
        if (response.success) {
            if (response.role === "admin") {
                location.replace("admin.php");
            } else {
                location.replace("dashboard.html");
            }
        } else {
            $("#loading").prop("hidden", true);
            $("#loginScreen").prop("hidden", false);
            alert("Wrong username or password");
        }
    }, "json").fail(function() {
        $("#loading").prop("hidden", true);
        $("#loginScreen").prop("hidden", false);
        alert("Unable to sign in. Please try again.");
    });
}

function verifySession(){
    $.get("php/data/get_user_session.php", {}, function (response) {
        if (response.success && response.role == "admin"){
            location.replace("admin.php");
        } else if (response.success && response.role == "user") {
            location.replace("dashboard.html");
        }
    }, "json");
}

function logout(){
    $.get("php/ac/logout.php", {}, function (response) {
        if (response.success){
            location.replace("login.html");
        }
    }, "json");
}

