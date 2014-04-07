
function submitPost(title, content, callback) {
    $.ajax({
        "url": "ajax/addPost.php",
        "type": "POST",
        "data": {
            "title": title,
            "content": content
        },
        "success": function(data) {
            getPosts();

            callback();
        }
    })
}

function submitComment(postID, content, callback) {
    $.ajax({
        "url": "ajax/addComment.php",
        "type": "POST",
        "data": {
            "postID": postID,
            "content": content
        },
        "success": function(data) {
            callback();
        }
    })
}

function getPosts() {
    $.ajax({
        "url": "ajax/getPosts.php",
        "type": "GET",
        "success": function(data) {

            dust.render("post", data, function(err, out) {
                $("#postContainer").html(out);
            });

        }
    })
}


function doLogin(username, password) {
    $.ajax({
        "url": "ajax/doLogin.php",
        "type": "POST",
        "data": {
            "username": username,
            "password": password
        },
        "success": function(data) {
            if(data['error'] == 0) {
                $("#lblUsername").text(username);
                $("#loginHeader").show();
                $("#btnSettings").show();

                if(data['canPost'] == 1) {
                    $("#btnNewPost").show();
                }

                $("#btnLogin, #btnRegister").hide();

                $("#mdlLogin").modal('hide');
            } else {
                alert("Invalid login credentials");
            }
        }
    })
}

function doRegister(username, password, callback) {
    $.ajax({
        "url": "ajax/doRegister.php",
        "type": "POST",
        "data": {
            "username": username,
            "password": password
        },
        "success": function(data) {
            switch(data['error']) {
                case 0:
                    callback(data);
                    break;

                case 1:
                    alert("Username not available.");
                    break;

                case 2:
                    alert("Username/password length invalid.");r
                    break;

                case 3:
                    alert("Database failure. Please try again.");
                    break;

                default:
                    alert("Unknown error");
                    break;
            }
        }
    });
}

function loadComments(postID, callback) {
    $.ajax({
        "url": "ajax/getComments.php",
        "type": "GET",
        "data": {
            "postID": postID
        },
        "success": function(data) {
            if(callback) {
                callback(data);
            }
        }
    });
}

//This event is called when the page first loads.
$(document).ready(function() {

    //Get posts on initial load
    getPosts();

    $("#mdlRegister_txtUsername").alphanumeric();
    $("#mdlRegister_txtPassword").alphanumeric();
    $("#mdlRegister_txtCPassword").alphanumeric();

    //Setup our add post modal
    $("#mdlNewPost").modal({
        keyboard: false,
        show: false
    }).on('hidden.bs.modal', function() {
        $("#mdlNewPost").find(":input, textarea").val("");
    });

    //Setup our login modal
    $("#mdlLogin").modal({
        keyboard: false,
        show: false
    }).on('hidden.bs.modal', function() {
        $("#mdlLogin").find(":input").val("");
    });

    //Setup our registration modal
    $("#mdlRegister").modal({
        keyboard: false,
        show: false
    }).on('hidden.bs.modal', function() {
        $("#mdlRegister").find(":input").val("");
    });

    //This sets up an event handler for when the new post button is clicked.
    $("#btnNewPost").on('click', function(e) {
        e.preventDefault();

        $("#mdlNewPost").modal('show');
    });

    //Event handler for submit post button
    $("#btnSubmitPost").on('click', function(e) {
        e.preventDefault();

        var title = $.trim($("#txtPostTitle").val());
        var content = $.trim($("#txtPostContent").val());

        if(title.length > 0) {
            if(content.length > 0) {
                if(title.length <= 256) {

                    submitPost(title, content, function() {
                        $("#mdlNewPost").modal('hide');
                    });

                } else alert("Your title is too long. Maximum length is 256 characters.");
            } else alert("Your post cannot be blank.");
        } else alert ("Your title cannot be blank.");
    });

    //Event handler for sidenav login button
    $("#btnLogin").on('click', function(e) {
        e.preventDefault();

        $("#mdlLogin").modal('show');
    });

    //Event handler for sidenav registration button
    $("#btnRegister").on('click', function(e) {
        e.preventDefault();

        $("#mdlRegister").modal('show');
    });

    //Event handler for in-modal Login button
    $("#btnDoLogin").on('click', function(e) {
        e.preventDefault();

        var user = $.trim($("#txtUsername").val());
        var pass = $.trim($("#txtPassword").val());

        if(user.length > 0) {
            if(pass.length > 0) {
                doLogin(user, $.sha1(pass));
            } else alert("Your password cannot be blank.");
        } else alert ("Your username cannot be blank.");


    });

    //Event handler for in-modal Register button
    $("#btnDoRegister").on('click', function(e) {
        e.preventDefault();

        var user = $.trim($("#mdlRegister_txtUsername").val());
        var pass = $.trim($("#mdlRegister_txtPassword").val());
        var cpass = $.trim($("#mdlRegister_txtCPassword").val());

        if(user.length >= 6 && user.length <= 20) {
            if(pass.length >= 6 && pass.length <= 20) {
                if(pass == cpass) {
                    doRegister(user, $.sha1(pass), function(data) {
                        $("#lblUsername").text(user);
                        $("#loginHeader").show();
                        $("#btnSettings").show();

                        $("#btnLogin, #btnRegister").hide();

                        $("#mdlRegister").modal('hide');
                    });
                } else alert("Your passwords do not match.");
            } else alert("Your password must contain between 6 and 20 characters");
        } else alert("Your username must contain between 6 and 20 characters");

    });

    $("#postContainer").on("click", ".btnToggleComments", function(e) {
        var $this = $(this).closest(".blogPost"); //Preserve 'this' context (the blog post)
        var $postComments = $this.find(".postComments");
        var postID = parseInt($this.attr("data-postID"));

        if(postID) {
            if($postComments.is(":visible")) {

                $postComments.slideUp('fast', function() {
                    $(this).empty(); //'this' here is .postComments we found in the current blogPost
                });
            } else {
                loadComments(postID, function(data) {
                    dust.render("comment", data, function(err, out) {
                        //'this' in this context is different because we're inside 2 anonymous functions. If you enter an anonymous function your context changes.
                        $postComments.html(out).slideDown('fast');
                    });
                });
            }
        }
    });

    $("#postContainer").on('keyup', ".txtComment", function(e) {
        if(e.which == 13) { //Enter key
            var $this = $(this).closest(".blogPost");
            var $postComments = $this.find(".postComments");
            var comment = $.trim($(this).val());
            var postID = parseInt($this.attr("data-postID"));

            if(comment.length > 0) {
                submitComment(postID, comment, function() {
                    $("#postContainer").find(":input").val("");

                    if(postID) {
                        loadComments(postID, function(data) {
                            dust.render("comment", data, function(err, out) {
                                //'this' in this context is different because we're inside 2 anonymous functions. If you enter an anonymous function your context changes.
                                $postComments.html(out).slideDown('fast');
                            });
                        });
                    }
                });
            } else alert ("Your comment cannot be blank.");
        }
    });

});