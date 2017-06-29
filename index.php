<?php
session_start();
require_once("class.event.php");
$login = new EVENT();
if ($login->is_loggedin() != "") {
    $login->redirect("home.php");
}
if (isset($_POST['submit'])) {
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    $error = array();
    if (empty($_POST['Username'])) {
        $error["Username"] = "Please Enter Username";
    }
    if (empty($_POST['Password'])) {
        $error["Password"] = "Please Enter Password";
    }
    if (!empty($_POST["Username"]) && !empty($_POST["Password"])) {
        if ($login->dologin($Username, $Password)) {
            if ($_SESSION['is_admin'] == 1) {
                $login->redirect("home.php");
            } else {
                $login->redirect("../AdminModule/UserModule/index.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Login Page - Event Admin</title>
        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="assets/css/ace.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">Event</span>
                                    <span class="white" id="id-text2">Admin</span>
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; Silvertouch Ltd.</h4>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="ace-icon fa fa-coffee green"></i>
						Please Enter Your Information
                                            </h4>

                                            <div class="space-6"></div>

                                            <form id="login1" name="login1" id="login1" method="POST" enctype="multipart/form-data">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="Username" id="Username" class="form-control" placeholder="Username" />
                                                            <span><?php if (isset($error["Username"])) { ?><span><?php echo $error["Username"]; ?></span><?php } ?></span>
                                                            <i class="ace-icon fa fa-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="Password" class="form-control" placeholder="Password" />
                                                            <span><?php if (isset($error["Password"])) { ?><span><?php echo $error["Password"]; ?></span><?php } ?></span>
                                                            <i class="ace-icon fa fa-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"> Remember Me</span>
                                                        </label>

                                                        <input type="submit" class="width-35 pull-right btn btn-sm btn-primary" name="submit" id="submit" />
                                                        <i class="ace-icon fa fa-key"></i>


                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                            <div class="social-or-login center">
                                                <span class="bigger-110">Or Login Using</span>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="social-login center">
                                                <a class="btn btn-primary">
                                                    <i class="ace-icon fa fa-facebook"></i>
                                                </a>

                                                <a class="btn btn-info">
                                                    <i class="ace-icon fa fa-twitter"></i>
                                                </a>

                                                <a class="btn btn-danger">
                                                    <i class="ace-icon fa fa-google-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
													I forgot my password
                                                </a>
                                            </div>

                                            <div>
                                                <a href="signup.php" class="user-signup-link">
													I want to register
                                                    <i class="ace-icon fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="ace-icon fa fa-key"></i>
												Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
						Enter your email and to receive instructions
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110">Send Me!</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <div class="navbar-fixed-top align-right">
                                <br />
                                &nbsp;
                                <a id="btn-login-dark" href="#">Dark</a>
                                &nbsp;
                                <span class="blue">/</span>
                                &nbsp;
                                <a id="btn-login-blur" href="#">Blur</a>
                                &nbsp;
                                <span class="blue">/</span>
                                &nbsp;
                                <a id="btn-login-light" href="#">Light</a>
                                &nbsp; &nbsp; &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function (){
                $("#submit").click(function(){
                    $("#login1").valid();
                });

                jQuery.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
                }, "Letters only please"); 

                $("#login1").validate({
                    rules:
                        {
                        Username: {
                            required: true,
                            lettersonly: true
                        },
                        Password: {
                            required: true
                        }
                    },
                    messages: 
                        {
                            Username:{
                                required: "Please Enter Username"
                            },
                            Password:{
                                required: "Please Enter Password"
                            }
                     	}
//                       	 onkeyup: function(element,event)
//                         {
//                        	if(event.which == 13 || this.elementValue(element) === "")
//                        	{
//                         		return;
//                        	}
//                         	else 
//                                {
//                                    this.element(element);
//                                }
//                          },
//                        focusout: function(element)
//                        {
//                        	this.element(element);
//                        }
//                          });
                        });
        </script>
    </body>
</html>
