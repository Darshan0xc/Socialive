$(document).ready(function () {
    
    //On click signup, hide login form and show signup form
    $("#signup").click(function () {
        $("#first").slideUp("slow", function () {
            $("#second").slideDown("slow")
        })
    });
    
    //On click login, hide signup form and show login form
    $("#signin").click(function () {
        $("#second").slideUp("slow", function () {
            $("#first").slideDown("slow")
        })
    });
    
});