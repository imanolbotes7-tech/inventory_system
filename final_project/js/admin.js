window.addEventListener("auth", function (){
    
    let json = JSON.parse(session_details);
    $("#welcome-message").html("Hello " + json.full_name + "!"); //changed for consistency with session variable names

});

// $(document).ready(function () {
//     $post
// })