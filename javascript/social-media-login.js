// Loads Google JavaScript SDK and attaches event listener to Google login button
function loadGoogleSDKAndAttachClickHandler() {
    var google_client_id = "YOUR_GOOGLE_CLIENT_ID";
    try {
        gapi.load('auth2', function(){
            var auth2 = gapi.auth2.init({
                client_id: google_client_id,
                cookiepolicy: 'single_host_origin',
            });
            var element = document.getElementById('google-login-button');
            auth2.attachClickHandler(element, {}, function(googleUser) {
                var id_token = googleUser.getAuthResponse().id_token;
                var operation = $("#social-media-login-operation").val();
                var login_url = "apis/google-login";
                var register_url = "apis/google-register";
                var url = operation === "login" ? login_url : (operation === "register" ? register_url : "");
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {"id_token" : id_token},
                    dataType: "JSON",
                    success: function(response){
                        if (response.error){
                            if (operation === "login"){
                                $("#login-error-message").html(response.message);
                                $("#login-error-message").addClass("input-error");
                            } else if (operation === "register"){
                                $("#register-generic-error-message").html(response.message);
                                $("#register-generic-error-message").addClass("input-error");
                            } else {
                                window.location.replace("error");
                            }
                        } else {
                            window.location.replace("provide-username");
                        }
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }, function(error) {
                console.log(error);
            });
        });
    } catch (exception){
        console.log(exception);
    }
}

// Loads the Facebook JavaScript SDK
function loadFacebookSDK(){
    var FACEBOOK_APP_ID = "YOUR_FACEBOOK_APP_ID";
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=' + FACEBOOK_APP_ID + '&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
}

// Returns a nonce
function getNonce(){
    var nounce = "";
    var length = 16;
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++) {
        nounce += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return nounce;
}

// Facebook Callback
function facebookCallback(){
    try {
        var nonce = getNonce();
            FB.login(function(response){
                if (response.status === 'connected') {
                    var access_token = response.authResponse.accessToken;
                    if (access_token != null){
                        FB.api('/me?fields=email', function(response) {
                            var social_media_id = response.id;
                            var operation = $("#social-media-login-operation").val();
                            var login_url = "apis/facebook-login";
                            var register_url = "apis/facebook-register";
                            var url = operation === "login" ? login_url : (operation === "register" ? register_url : "");
                            $.ajax({
                                url: url,
                                type: "POST",
                                data: {"social_media_id" : social_media_id, "access_token" : access_token},
                                dataType: "JSON",
                                success: function(response){
                                    if (response.error){
                                        if (operation === "login"){
                                            $("#login-error-message").html(response.message);
                                            $("#login-error-message").addClass("input-error");
                                        } else if (operation === "register"){
                                            $("#register-generic-error-message").html(response.message);
                                            $("#register-generic-error-message").addClass("input-error");
                                        } else {
                                            window.location.replace("error");
                                        }
                                    } else {
                                        window.location.replace("provide-username");
                                    }
                                },
                                error: function(response){
                                    console.log(response);
                                }
                            });
                        });
                    }
                }
            }, { scope: 'email', auth_type: 'reauthenticate', auth_nonce: nonce });
    } catch (exception){
        errorService.error();
    }
}

$(document).ready(function(){  

    // Load Google JavaScript SDK and attach event listener to Google login button
    loadGoogleSDKAndAttachClickHandler();

    // Load Facebook JavaScript SDK
    loadFacebookSDK();

    // Attach onclick event listener to Facebook login button
    $("#facebook-login-button").click(facebookCallback);

});