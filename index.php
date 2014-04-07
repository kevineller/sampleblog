<?php

    $loggedIn = false;
    $canPost = false;

    session_start();

    if(isset($_SESSION['auth']) && $_SESSION['auth']) {
        $loggedIn = true;
        $canPost = $_SESSION['canPost'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sample Blog</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-fixed.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js" type="text/javascript"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js" type="text/javascript"></script>
    <![endif]-->
</head>
<body>

<h1 id="blogHeader">Sample Blog</h1>
<span id="loginHeader" <?php if(!$loggedIn): ?>style="display: none;"<?php endif; ?>>
    Logged in as&nbsp;
    <span id="lblUsername"><?php if($loggedIn) echo $_SESSION['username']; ?></span>&nbsp;
    <a href="logout.php" title="Logout"><i class="glyphicon glyphicon-log-out"></i></a>
</span>

<div class="row">
    <div class="col-xs-2">
        <div id="sideNav">
            <button class="btn btn-success" style="width: 100%; margin-bottom: 10px; <?php if(!$canPost): ?>display: none;<?php endif; ?>" type="button" id="btnNewPost">Add Post</button>
            <a href="settings.php" class="btn btn-warning" style="width: 100%; margin-bottom: 10px;<?php if(!$loggedIn): ?> display: none;<?php endif; ?>" type="button" id="btnSettings">Settings</a>
            <?php if(!$loggedIn): ?>
                <button class="btn btn-success" style="width: 100%; margin-bottom: 10px;" type="button" id="btnLogin">Login</button>
                <button class="btn btn-success" style="width: 100%; margin-bottom: 10px;" type="button" id="btnRegister">Register</button>
            <?php endif; ?>

        </div>
    </div>

    <div class="col-xs-10">
        <div id="postContainer">
        </div>
    </div>
</div>

<div id="mdlNewPost" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-plus-sign"></i> New Post</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="txtPostTitle" class="col-xs-2 control-label">Title:</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" id="txtPostTitle" placeholder="Enter a title for this post"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtPostContent" class="col-xs-2 control-label">Content:</label>
                        <div class="col-xs-10">
                            <textarea style="resize: none; height: 125px;" class="form-control" id="txtPostContent" placeholder="Enter the content of your post"></textarea>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="btnSubmitPost" class="btn btn-primary">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="mdlLogin" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i> Login</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="txtUsername" class="col-xs-2 control-label">Username:</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="txtUsername" placeholder="Username"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtPassword" class="col-xs-2 control-label">Password:</label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="txtPassword" placeholder="Password"/>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnDoLogin" class="btn btn-primary">Login</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Registration modal -->
<div id="mdlRegister" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-users">&nbsp;</i>Register</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="mdlRegister_txtUsername" class="col-xs-2 control-label">Username:</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" id="mdlRegister_txtUsername" placeholder="Username" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mdlRegister_txtPassword" class="col-xs-2 control-label">Password:</label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="mdlRegister_txtPassword" placeholder="Password"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mdlRegister_txtCPassword" class="col-xs-2 control-label">Confirm Password:</label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="mdlRegister_txtCPassword" placeholder="Password"/>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnDoRegister" class="btn btn-primary">Register</button>
            </div>
        </div>
    </div>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.js" type="text/javascript"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/dust-full-2.0.3.js" type="text/javascript"></script>
<script src="js/dust-helpers-1.1.1.js" type="text/javascript"></script>
<script src="js/jquery.sha1.js" type="text/javascript"></script>
<script src="js/jquery.alphanumeric.pack.js" type="text/javascript"></script>

<!-- Templates -->
<script src="js/templates/blog_post.js" type="text/javascript"></script>
<script src="js/templates/blog_comment.js" type="text/javascript"></script>

<!-- Page Code -->
<script src="js/page-includes/index.js" type="text/javascript"></script>

</body>
</html>
