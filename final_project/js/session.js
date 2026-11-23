var session_details;

$(document).ready(function(){

    checkSession();


});



function checkSession() {
    //check session here

    $.get("php/data/get_user_session.php", {}, function (response) {

        let rsp = JSON.parse(response);
        if (rsp.success) {

            session_details = response;
            let event = new CustomEvent("auth", {});
            window.dispatchEvent(event);
        }else {
            location.replace("login.html");
        }


    });


}