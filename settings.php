<?php
include("view/viewFunctions.php");

$loggedIn = false;
$canPost = false;

session_start();

if(isset($_SESSION['auth']) && $_SESSION['auth']) {
    $loggedIn = true;
    $canPost = $_SESSION['canPost'];
    $avPath = $_SESSION['avPath'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sample Blog - Settings</title>

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
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.js" type="text/javascript"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/dust-full-2.0.3.js" type="text/javascript"></script>
<script src="js/dust-helpers-1.1.1.js" type="text/javascript"></script>
<script src="js/jquery.sha1.js" type="text/javascript"></script>
<script src="js/jquery.alphanumeric.pack.js" type="text/javascript"></script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>

<h1 id="blogHeader">Sample Blog</h1>
<span id="loginHeader" <?php if(!$loggedIn): ?>style="display: none;"<?php endif; ?>>
    Logged in as&nbsp;
    <span id="lblUsername"><?php if($loggedIn) echo $_SESSION['username']; ?></span>&nbsp;
    <a href="logout.php" title="Logout"><i class="glyphicon glyphicon-log-out"></i></a>
</span>

<div class="row">
    <div class="col-xs-2">
        <div id="sideNav">
            <a href="index.php" class="btn btn-success" style="width: 100%; margin-bottom: 10px;" type="button" id="btnHome">Home</a>

        </div>
    </div>

    <div class="col-xs-10">
        <div><i class="glyphicon glyphicon-cog"></i>&nbsp;Settings</div>
        <div id="userSettings">
            <div><button class="btn btn-default btn-sm" style="margin-bottom: 10px;" type="button" id="btnChangePass">Change Password</button></div>
            <div id="changePass" style="display: none; margin-bottom: 10px;">

                <form class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="txtCurrentPass" class="col-xs-3 control-label">Current Password:</label>
                        <div class="col-xs-3">
                            <input type="password" class="form-control" id="txtCurrentPass" placeholder="Current Password"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtNewPass" class="col-xs-3 control-label">New Password:</label>
                        <div class="col-xs-3">
                            <input type="password" class="form-control" id="txtNewPass" placeholder="New Password"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtCNewPass" class="col-xs-3 control-label">Confirm New Password:</label>
                        <div class="col-xs-3">
                            <input type="password" class="form-control" id="txtCNewPass" placeholder="New Password (again)"/>
                        </div>
                    </div>

                </form>

                <div style="margin-bottom: 20px;">
                    <button id="btnCancelChangePass" class="btn btn-default" type="button">Cancel</button>
                    <button id="btnDoChangePass" class="btn btn-primary" type="button">Change Password</button>
                </div>
            </div>

            <div><button class="btn btn-default btn-sm" style="margin-bottom: 10px;" type="button" id="btnChangeAv">Change Avatar</button></div>

            <div id="changeAv" style="display: none; margin-bottom: 10px;">

                <div class="form-group">
                    <label class="col-xs-3 control-label">Current Avatar:</label>
                    <div class="col-xs-3">
                        <img src="upload/<?php echo getAvatarURL(); ?>" width="100">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-6">
                        <form action="ajax/changeAv.php" method="post" enctype="multipart/form-data">
                            <label for="file">Filename:</label>
                            <input type="file" name="file" id="file"><br>
                            <input class="btn btn-primary" type="submit" name="submit" value="Change Avatar">
                            <button id="btnCancelChangeAv" class="btn btn-default" type="button">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Modals -->





<!-- Templates -->
<script src="js/templates/blog_post.js" type="text/javascript"></script>
<script src="js/templates/blog_comment.js" type="text/javascript"></script>

<!-- Page Code -->
<script src="js/page-includes/settings.js" type="text/javascript"></script>

</body>
</html>
