$("input[type=password]").keyup(function()
{
    var ucase = new RegExp("[A-Z]+");
    var lcase = new RegExp("[a-z]+");
    var num = new RegExp("[0-9]+");

    if($("#password1").val().length >= 8)
    {
        $("#8char").removeClass("fa-times");
        $("#8char").addClass("fa-check");
        $("#8charContainer").css("color","#06c106");
    }
    else
    {
        $("#8char").removeClass("fa-check");
        $("#8char").addClass("fa-times");
        $("#8charContainer").css("color","#FF0004");
        document.getElementById("change-pass-btn").disabled = true; 
    }
    
    if(ucase.test($("#password1").val()))
    {
        $("#ucase").removeClass("fa-times");
        $("#ucase").addClass("fa-check");
        $("#ucaseContainer").css("color","#06c106");
    }
    else{
        $("#ucase").removeClass("fa-check");
        $("#ucase").addClass("fa-times");
        $("#ucaseContainer").css("color","#FF0004");
        document.getElementById("change-pass-btn").disabled = true; 
    }
    
    if(lcase.test($("#password1").val()))
    {
        $("#lcase").removeClass("fa-times");
        $("#lcase").addClass("fa-check");
        $("#lcaseContainer").css("color","#06c106");
    }
    else
    {
        $("#lcase").removeClass("fa-check");
        $("#lcase").addClass("fa-times");
        $("#lcaseContainer").css("color","#FF0004");
        document.getElementById("change-pass-btn").disabled = true;  
    }
    
    if(num.test($("#password1").val()))
    {
        $("#num").removeClass("fa-times");
        $("#num").addClass("fa-check");
        $("#numContainer").css("color","#06c106");
    }
    else{
        $("#num").removeClass("fa-check");
        $("#num").addClass("fa-times");
        $("#numContainer").css("color","#FF0004");
        document.getElementById("change-pass-btn").disabled = true;  
    }
    
    if(($("#password1").val() != "" && $("#password1").val() != "") && ($("#password1").val() == $("#password2").val()))
    {
        $("#pwmatch").removeClass("fa-times");
        $("#pwmatch").addClass("fa-check");
        $("#pwmatchContainer").css("color","#06c106");
    }
    else
    {
        $("#pwmatch").removeClass("fa-check");
        $("#pwmatch").addClass("fa-times");
        $("#pwmatchContainer").css("color","#FF0004");
        document.getElementById("change-pass-btn").disabled = true; 
    }

    if(($("#password1").val() != "" && $("#password1").val() != "") && ($("#password1").val() == $("#password2").val()) && ($("#password1").val().length >= 8) && (ucase.test($("#password1").val())) && (lcase.test($("#password1").val())) && (num.test($("#password1").val()))) 
    {
        document.getElementById("change-pass-btn").disabled = false; 
    }
    else
    {
        document.getElementById("change-pass-btn").disabled = true; 
    }
});