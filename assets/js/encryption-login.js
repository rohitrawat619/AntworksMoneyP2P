function enc_borrower()
{
    var password = $("#pwd").val();
    var username = $("#user").val();
    var hash = $("#hash_value").val();
    if(username == ''){
        alert("Please Enter Username");
        return false;
    }
    if(password == '')
    {
        alert("Please Enter Password");
        return false;
    }
    else{
        var crypted_password = CryptoJS.SHA512(password);
        var combine_pass = crypted_password+hash;
        var crypted = CryptoJS.SHA512(combine_pass);
        $('#pwd').val(crypted);
    }
}

function enc_lender()
{
    var password = $("#pwd").val();
    var username = $("#user").val();
    var hash = $("#hash_value").val();
    if(username == ''){
        alert("Please Enter Username");
        return false;
    }
    if(password == '')
    {
        alert("Please Enter Password");
        return false;
    }
    else{
        var crypted_password = CryptoJS.SHA512(password);
        var combine_pass = crypted_password+hash;
        var crypted = CryptoJS.SHA512(combine_pass);
        $('#pwd').val(crypted);
    }
}

function enc_user_login()
{
    var password = $("#pwd").val();
    var username = $("#user").val();
    var hash = $("#hash_value").val();
    if(username == ''){
        alert("Please Enter Username");
        return false;
    }
    if(password == '')
    {
        alert("Please Enter Password");
        return false;
    }
    else{
        var crypted_password = CryptoJS.SHA512(password);
        var combine_pass = crypted_password+hash;
        var crypted = CryptoJS.SHA512(combine_pass);
        $('#pwd').val(crypted);
    }
}

function enc_change_password() {
    var password = $("#pwd").val();
    var cpassword = $("#cpwd").val();
    var validate = true;
    if(password == '')
    {
      $("#error_pwd").html("<p style='color:red; font-size: 11px'>Please enter password</p>");
        validate = false;
    }
    if(cpassword == '')
    {
        $("#error_pwd").html("<p style='color:red; font-size: 11px'>Please enter confirm passord</p>");
        validate = false;
    }
    if(password != cpassword)
    {
        $("#error_cpwd").html("<p style='color:red; font-size: 11px'>Password and confirm password not match</p>");
        validate = false;
    }
    if(validate == true)
    {
        var crypted_password = CryptoJS.SHA512(password);
        var crypted_confirm_password = CryptoJS.SHA512(cpassword);
        $("#pwd").val(crypted_password);
        $("#cpwd").val(crypted_confirm_password);
        return true;
    }
    else{
        return false;
    }
}

function enc_change_password_lender() {
    var oldpassword = $("#old_pwd").val();
    var password = $("#pwd").val();
    var cpassword = $("#cpwd").val();
    var validate = true;
    if(oldpassword == '')
    {
        $("#error_old_pwd").html("<p style='color:red; font-size: 11px'>Please enter old password</p>");
        validate = false;
    }
    if(password == '')
    {
        $("#error_pwd").html("<p style='color:red; font-size: 11px'>Please enter password</p>");
        validate = false;
    }
    if(cpassword == '')
    {
        $("#error_cpwd").html("<p style='color:red; font-size: 11px'>Please enter confirm passord</p>");
        validate = false;
    }
    if(password != cpassword)
    {
        $("#error_cpwd").html("<p style='color:red; font-size: 11px'>Password and confirm password not match</p>");
        validate = false;
    }
    if(validate == true)
    {
        var crypted_old_password = CryptoJS.SHA512(oldpassword);
        var crypted_password = CryptoJS.SHA512(password);
        var crypted_confirm_password = CryptoJS.SHA512(cpassword);
        $("#old_pwd").val(crypted_old_password);
        $("#pwd").val(crypted_password);
        $("#cpwd").val(crypted_confirm_password);
        return true;
    }
    else{
        return false;
    }
}
