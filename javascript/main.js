$(document).ready(function(){

    /********** Generic **********/
    $("input[type=text], input[type=password]").focus(function(){
        if (!$(this).hasClass("input-error")){
            $(this).removeClass("input-error").addClass("input-hover");
        }
    });
    $("input[type=text], input[type=password]").blur(function(event){
        $(this).removeClass("input-hover");
    });
    
    /********** Navigation **********/
    $("#navigation-hamburger-icon").click(function(){
        $("#side-navigation").width(250);
    });
    $("body").click(function(event){
        if (event.target.id !== "side-navigation" && $("#side-navigation").width() > 0){
            $("#side-navigation").width(0);
        }
    });
    $(window).resize(function(){
        if ($(this).width() > 768){
            $("#side-navigation").width(0);
        }
    });

    /********** Membership **********/
    $("#register-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/register",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.email.error === false && 
                    response.username.error === false && 
                    response.password.error === false && 
                    response.confirm_password.error === false &&
                    response.generic.error === false){
                    window.location.replace("activate-account");
                } else {
                    $("#register-form :input[type=text], #register-form :input[type=password]").each(function(){
                        var id = $(this).attr("id");
                        var name = $(this).attr("name");
                        if (response[name].error){
                            $("#" + id + "-error-message").html(response[name].error_message);
                            $("#" + id).addClass("input-error");
                        } else {
                            $("#" + id + "-error-message").html("");
                            $("#" + id).removeClass("input-error");
                        }
                    });
                }
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#register-password, #password-reset-password").keyup(function(){
        var password = $(this).val();
        var uppercase_regex = RegExp("^(?=.*[A-Z])");
        var lowercase_regex = RegExp("^(?=.*[a-z])");
        var number_regex= RegExp("^(?=.*[0-9])");
        var special_character_regex = RegExp("^(?=.*[^a-zA-Z0-9])");
        if (uppercase_regex.test(password)){
            $("#password-requirement-uppercase-letter").addClass("password-requirement-disabled");
        } else {
            $("#password-requirement-uppercase-letter").removeClass("password-requirement-disabled");
        }
        if (lowercase_regex.test(password)){
            $("#password-requirement-lowercase-letter").addClass("password-requirement-disabled");
        } else {
            $("#password-requirement-lowercase-letter").removeClass("password-requirement-disabled");
        }
        if (number_regex.test(password)){
            $("#password-requirement-number").addClass("password-requirement-disabled");
        } else {
            $("#password-requirement-number").removeClass("password-requirement-disabled");
        }
        if (special_character_regex.test(password)){
            $("#password-requirement-special-character").addClass("password-requirement-disabled");
        } else {
            $("#password-requirement-special-character").removeClass("password-requirement-disabled");
        }
        if (password.length >= 8){
            $("#password-requirement-eight-characters").addClass("password-requirement-disabled");
        } else {
            $("#password-requirement-eight-characters").removeClass("password-requirement-disabled");
        }
    });
    $("#login-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/login",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    window.location.replace("/notestore");
                } else {
                    $("#login-error-message").html(response.error_message);
                }
            },
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#forgot-password-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/forgot-password",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    $("#forgot-password-error-message").html("");
                    $("#forgot-password-email-or-username").removeClass("input-error");
                    $("forgot-password-email-or-username").val("");
                    $("#forgot-password-form-container").addClass("hidden");
                    $("#forgot-password-success-container").removeClass("hidden");
                    $("#forgot-password-resend-email-or-username").val(response.email_or_username);
                } else {
                    $("#forgot-password-error-message").html(response.message);
                    $("#forgot-password-email-or-username").addClass("input-error");
                    $("#forgot-password-form-container").removeClass("hidden");
                    $("#forgot-password-success-container").addClass("hidden");
                    $("#forgot-password-resend-id").val("");
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#forgot-password-resend-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/forgot-password",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    $("#forgot-password-resend-response-message").removeClass("error-color").addClass("success-color").html(response.message);
                } else {
                    $("#forgot-password-resend-response-message").removeClass("success-color").addClass("error-color").html(response.message);
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#reset-password-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/reset-password",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.password.error === false && 
                    response.confirm_password.error === false &&
                    response.generic.error === false){
                    $("#reset-password-form :input[type=password]").each(function(){
                        var id = $(this).attr("id");
                        $("#" + id + "-error-message").html("");
                        $("#" + id).removeClass("input-error");
                    });
                    $("#reset-password-form-container").addClass("hidden");
                    $("#reset-password-success-container").removeClass("hidden");
                } else {
                    $("#reset-password-form-container").removeClass("hidden");
                    $("#reset-password-success-container").addClass("hidden");
                    $("#reset-password-form :input[type=password]").each(function(){
                        var id = $(this).attr("id");
                        var name = $(this).attr("name");
                        if (response[name].error){
                            $("#" + id + "-error-message").html(response[name].error_message);
                            $("#" + id).addClass("input-error");
                        } else {
                            $("#" + id + "-error-message").html("");
                            $("#" + id).removeClass("input-error");
                        }
                    });
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#forgot-username-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/forgot-username",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    $("#forgot-username-error-message").html("");
                    $("#forgot-username-email").removeClass("input-error");
                    $("forgot-username-email").val("");
                    $("#forgot-username-form-container").addClass("hidden");
                    $("#forgot-username-success-container").removeClass("hidden");
                    $("#forgot-username-resend-email").val(response.email);
                } else {
                    $("#forgot-username-error-message").html(response.message);
                    $("#forgot-username-email").addClass("input-error");
                    $("#forgot-username-form-container").removeClass("hidden");
                    $("#forgot-username-success-container").addClass("hidden");
                    $("#forgot-username-resend-email").val("");
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#forgot-username-resend-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/forgot-username",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    $("#forgot-username-resend-response-message").removeClass("error-color").addClass("success-color").html(response.message);
                } else {
                    $("#forgot-username-resend-response-message").removeClass("success-color").addClass("error-color").html(response.message);
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#activate-account-resend-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/activate-account",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error === false){
                    $("#activate-account-resend-response-message").removeClass("error-color").addClass("success-color").html(response.message);
                } else {
                    $("#activate-account-resend-response-message").removeClass("success-color").addClass("error-color").html(response.message);
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });
    $("#provide-username-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:"apis/provide-username",
            type:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(response){
                if (response.error){
                    $("#provide-username-error-message").removeClass("success-color").addClass("error-color").html(response.message);
                    $("#provide-username-username").addClass("input-error");
                } else {
                    window.location.replace("/notestore");
                }
            }, 
            error:function(response){
                console.log(response);
            }
        });
    });

});