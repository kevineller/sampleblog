//TODO ajax handler for change password/change avatar

function changePass(pass, newPass, callback) {
    $.ajax({
        "url": "ajax/changePass.php",
        "type": "POST",
        "data": {
            "pass": pass,
            "newPass": newPass
        },
        "success": function(data) {
            switch(data['error']) {
                case 0:
                    alert("Password changed.");
                    $("#changePass").hide();
                    $("#changePass").find(":input").val("");
                    callback(data);
                    break;
                case 1:
                    alert("Not authorized.");
                    break;
                case 2:
                    alert("Your password must be between 6 and 20 characters.");
                    break;
                case 3:
                    alert("Invalid password.");
                    break;
                case 4:
                    alert("Database error.");
                    break;
                default:
                    alert("Unknown error.");
                    break;
            }
        }
    });
}


$(document).ready(function() {

    //Event handler for Change Password button
    $("#btnChangePass").on('click', function(e) {
        e.preventDefault();

        if($("#changePass").is(':visible')) {
            $("#changePass").hide();
            $("#changePass").find(":input").val("");
        } else $("#changePass").show();

    });

    //Event handler for Cancel (Change Password) button
    $("#btnCancelChangePass").on('click', function(e) {
        e.preventDefault();

        $("#changePass").hide();
        $("#changePass").find(":input").val("");
    });

    //Event handler for Change Password (Change Password) button
    $("#btnDoChangePass").on('click', function(e) {
        e.preventDefault();

        var currentPass = $.trim($("#txtCurrentPass").val());
        var newPass = $.trim($("#txtNewPass").val());
        var cNewPass = $.trim($("#txtCNewPass").val());

        if(newPass.length >= 6 && newPass.length <= 20){
            if(newPass == cNewPass) {
                changePass($.sha1(currentPass), $.sha1(newPass), function(data) {

                });
            } else alert("Your passwords do not match.");
        } else alert("Your password must contain between 6 and 20 characters.");

    });

    //Event handler for Change Avatar button
    $("#btnChangeAv").on('click', function(e) {
        e.preventDefault();

        if($("#changeAv").is(':visible')) {
            $("#changeAv").hide();
            $("#changeAv").find(":input").val("");
        } else $("#changeAv").show();
    });

    //Event handler for Cancel (Change Avatar) button
    $("#btnCancelChangeAv").on('click', function(e) {
        e.preventDefault();
        $("#changeAv").hide();
        $("#changeAv").find(":input").val("");
    });


});