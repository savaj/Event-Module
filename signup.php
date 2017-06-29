<?php
session_start();
require_once("class.event.php");
$login = new EVENT();
if($login->is_loggedin() != ""){
	$login->redirect("home.php");
}
if(isset($_POST['signup']))
{	
	//echo"<pre>";print_r($_POST);
	//echo"<pre>";print_r($_FILES);exit;
	$user_name = htmlspecialchars($_POST['user_name']);
 	$user_mail = htmlspecialchars($_POST['user_mail']);
	$user_pass = htmlspecialchars($_POST['user_pass']);
	$user_profile = $_FILES["user_profile"]["name"];
	$ext = pathinfo($user_profile,PATHINFO_EXTENSION);
	$user_profile = basename( $_FILES["user_profile"]["name"]);
	$path = "UserProfile/".$user_profile;
	$result = move_uploaded_file($_FILES['user_profile']['tmp_name'],$path);

	$error = array();
	if(empty($_POST['user_name']))
	{
		 $error['user_name'] = "Please Enter Username";
	}
	if(empty($_POST['user_mail']))
	{
		  $error['user_mail'] = "Please Enter Usermail";
	}
	if(empty($_POST['user_pass']))
	{
		 $error['user_pass'] = "Please Enter UserPassword";
	}
	if(empty($user_profile))
	{
		$error['user_profile'] = "Please Select USerProfilePhoto";
	}
	if(!empty($_POST["user_name"]) && !empty($_POST["user_pass"]) && !empty($_POST["user_mail"]))
	{
		if($login->register($user_name,$user_mail,$user_pass,$user_profile))
		{
			$login->redirect("home.php");
		}
	
	}
	}

?>
<html>
<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
												<div class="login-container">				
										<div class="position-relative">
<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New User Registration
											</h4>

											<div class="space-6"></div>
											

											<form method="POST" enctype="multipart/form-data">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="user_mail" class="form-control" placeholder="Email" />
															<span><?php if(isset($error["user_mail"])){ ?><span class="error"><?php echo $error['user_mail']; ?></span><?php } ?></span>
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="user_name"class="form-control" placeholder="Username" />
													<span><?php if(isset($error["user_name"])){ ?><span class="error"><?php echo $error['user_name']; ?></span><?php } ?></span>
															<i class="ace-icon fa fa-user"></i>

														</span>
													</label>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="file" name="user_profile" id="user_profile" class="form-control" />
													<span><?php if(isset($error["user_profile"])){ ?><span class="error"><?php echo $error['user_profile']; ?></span><?php } ?></span>

															<i class="ace-icon fa fa-lock"></i>

															</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="user_pass" class="form-control" placeholder="Password" />
													<span><?php if(isset($error["user_pass"])){ ?><span class="error"><?php echo $error['user_pass']; ?></span><?php } ?></span>

															<i class="ace-icon fa fa-lock"></i>

															</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" />
	
															<i class="ace-icon fa fa-retweet"></i>
																																						
														</span>
													</label>

													<label class="block">
														<input type="checkbox" name="checkbox" id="checkbox" value="check" class="ace" />
														<span class="lbl">
															I accept the
															<a href="#">User Agreement</a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>

														<input type="submit" class="width-65 pull-right btn btn-sm btn-success" name="signup" id="signup">
															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="../AdminModule/index.php" data-target="#login-box" class="back-to-login-link">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
				
</body>
</html>