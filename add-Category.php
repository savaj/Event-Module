<?php
error_reporting(0);
require_once("session.php");
require_once("class.event.php");
require_once("category.php");
require_once("includes/config.php");
$db = new DATABASE();
$test = new CATEGORY();
$event = new EVENT();
if ((isset($_GET['action']) && $_GET['action'] == "update" && $_GET["category_id"])) {
    $categoryimage = $_FILES['categoryimage']['name'];
    $ext = pathinfo($categoryimage, PATHINFO_EXTENSION);
    $image = basename($_FILES['categoryimage']['name']);
    $path = "uploads/" . $image;
    $result = move_uploaded_file($_FILES['categoryimage']['tmp_name'], 'uploads/' . $image);

    $test2 = $db->connect()->prepare("select * from category where category_id = '" . $_GET["category_id"] . "'");
    $test2->execute();
    $userRow = $test2->fetchALL(PDO::FETCH_ASSOC);
    foreach ($userRow as $row) {

        $categoryname = $row["categoryname"];
        $categorydescription = $row["categorydescription"];
        $categoryimage = $row["categoryimage"];
        $status = $row["status"];
    }
    if (isset($_POST["test"]) && $_GET["category_id"]) {

        $category_name = $_POST["categoryname"];
        $category_description = $_POST["categorydescription"];
        $status = $_POST["status"];
        $categoryimage = $_FILES['categoryimage']['name'];
        $category_id = $_GET["category_id"];
        $allowed = array('gif', 'png', 'jpg');

        $filename = $_FILES['Image1']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $error = array();

        if (empty($_POST['categoryname'])) {
            $error['categoryname'] = "Please Enter Cateogry Name";
        }
        if (empty($_POST['categorydescription'])) {
            $error['categorydescription'] = "Please Enter Category Description";
        }
        if (empty($_POST["status"])) {
            $error["status"] = "Please Select Status";
        }
        if (!in_array($ext, $allowed) && !empty($categoryimage)) {
            $error['categoryimage'] = "Invalid Extension";
        }
        if (file_exists($_FILES["categoryimage"]["name"])) {
            $error['categoryimage'] = "File is already exists";
        } else {
            $error['categoryimage'] = 'file is not Already exists';
        }
        if (!empty($_FILES["categoryimage"]["name"])) {
            $sql = "UPDATE `category`   
  			 SET `categoryname` = '" . $_POST["categoryname"] . "',
  			 `categorydescription` = '" . $_POST["categorydescription"] . "',
       			`categoryimage` = '" . $_FILES['categoryimage']['name'] . "',
      			 `status` = '" . $_POST["status"] . "' 
				 WHERE `category_id` = '$category_id'";
            $test1 = $db->connect()->prepare($sql);
            $test1->execute();
            $event->redirect("list-category.php");
        } else {
            $sql = "UPDATE `category`   
  			 SET `categoryname` = '" . $_POST["categoryname"] . "',
  			 `categorydescription` = '" . $_POST["categorydescription"] . "',
      			 `status` = '" . $_POST["status"] . "' 
				 WHERE `category_id` = '$category_id'";
            $test1 = $db->connect()->prepare($sql);
            $test1->execute();
            $event->redirect("list-category.php");
        }
    }
}


if (isset($_POST["test"])) {

    $category_name = $_POST["categoryname"];
    $category_description = $_POST["categorydescription"];
    $status = $_POST["status"];
    $allowed = array('gif', 'png', 'jpg');
    $categoryimage = $_FILES['categoryimage']['name'];
    $ext = pathinfo($categoryimage, PATHINFO_EXTENSION);
    $error = array();
    if (empty($_POST["categoryname"])) {
        $error["categoryname"] = "Please Enter Cateogry Name";
    }
    if ($test->cat_check_duplicate($category_name)) {
        //echo "test";exit;
        $error["categoryname"] = "Your Category Name Already Exists.";
    }
    if (empty($_POST['categorydescription'])) {
        $error['categorydescription'] = "Please Enter Category Description";
    }
    if (empty($_FILES['categoryimage']['name'])) {
        $error["categoryimage"] = "Please Select Category Photo";
    } else if (!in_array($ext, $allowed)) {
        $error["categoryimage"] = "Invalid Photo";
    }
    if (empty($_POST["status"])) {
        $error["status"] = "Please Select Status";
    }
    if (empty($error)) {
        if (!empty($_POST["categoryname"]) && !empty($_POST["categorydescription"]) && !empty($_POST["status"]) && !empty($categoryimage)) {

            $image = basename($_FILES['categoryimage']['name']);
            $path = "uploads/" . $image;
            $result = move_uploaded_file($_FILES['categoryimage']['tmp_name'], 'uploads/' . $image);
            if ($test->add($category_name, $category_description, $categoryimage, $status)) {
                $event->redirect("list-category.php");
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
        <title>Form Elements - Ace Admin</title>

       
        <meta name="description" content="Common form elements and layouts" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

        <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <link rel="stylesheet" href="assets/css/datepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="assets/css/colorpicker.min.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="css/pickmeup.css" type="text/css" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/demo.css" />
        <style>
            .error{
                color:red;
            }

        </style>

        <script type="text/javascript">
            $(function(){
                $("#test").click(function(){
                    $("#myform").valid();
                });
                $("#myform").validate({
                    rules: {
                        categoryname: {
                            required: true
                        },
                        categorydescription: {
                            required: true
                        },
                        status: {
                            required: true
                        }
                    },
                    messages: {
                        categoryname: {
                            required: "Please Enter Category Name"
                        },
                        categorydescription: {
                            required: "Please Enter Category Description"
                        }, 			
                        status: {
                            required: "Please Select Status"
                        }
                    },
                    onkeyup: function(element,event){
                        if(event.which == 9 && this.elementValue(element) === "")
                        {
                            return;
                        }
                        else{
                            this.element(element);
                        }
                    },
                    onfocusout: function(element){
                        this.element(element);
                    }
                });
            });
        </script>




    </head>

    <body class="no-skin">
<?php require_once("header.php"); ?>

        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>

<?php require_once("sidebar.php"); ?>

            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                        </script>

                        <ul class="breadcrumb">
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="#">Home</a>
                            </li>

                            <li>
                                <a href="#">Forms</a>
                            </li>
                            <li class="active">Form Elements</li>
                        </ul><!-- /.breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- /.nav-search -->
                    </div>

                    <div class="page-content">
                        <div class="ace-settings-container" id="ace-settings-container">
                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                <i class="ace-icon fa fa-cog bigger-130"></i>
                            </div>

                            <div class="ace-settings-box clearfix" id="ace-settings-box">
                                <div class="pull-left width-50">
                                    <div class="ace-settings-item">
                                        <div class="pull-left">
                                            <select id="skin-colorpicker" class="hide">
                                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                            </select>
                                        </div>
                                        <span>&nbsp; Choose Skin</span>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                                        <label class="lbl" for="ace-settings-add-container">
											Inside
                                            <b>.container</b>
                                        </label>
                                    </div>
                                </div>

                                <div class="pull-left width-50">
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
                                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
                                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
                                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                    </div>
                                </div><!-- /.pull-left -->
                            </div><!-- /.ace-settings-box -->
                        </div><!-- /.ace-settings-container -->

                        <div class="page-header">
                            <h1>
								Form Elements
                                <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
									Common form elements and layouts
                                </small>
                            </h1>
                        </div><!-- /.page-header -->

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <form class="form-horizontal" role="form" name="myform" id="myform" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Title </label>

                                        <div class="col-sm-9">
                                            <input type="text"  name="categoryname" id="categoryname" placeholder="Category Name" class="col-xs-10 col-sm-5" value="<?php echo $categoryname; ?>" />
                                            <span><?php if (isset($error["categoryname"])) { ?><span class="error"><?php echo $error["categoryname"]; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description </label>

                                        <div class="col-sm-9">
                                            <input type="text"  name="categorydescription" id="categorydescription" placeholder="Cateogry Description" class="col-xs-10 col-sm-5" value="<?php echo $categorydescription; ?>" />
                                            <span><?php if (isset($error["categorydescription"])) { ?><span class="error"><?php echo $error["categorydescription"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>
                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image </label>

                                        <div class="col-sm-9">
                                            <input type="file"  name="categoryimage"  id="categoryimage" class="col-xs-10 col-sm-5"  />

<?php if (isset($row["categoryimage"])) { ?>
                                                <img src="uploads/<?php echo $row["categoryimage"]; ?>" height="50px" width="50">
<?php } ?>



                                            <span><?php if (isset($error["categoryimage"])) { ?><span class="error"><?php echo $error["categoryimage"]; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>																														
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status</label>

                                        <div class="col-sm-9">
                                            <div>
                                                <input type="radio" name="status" id="status" <?php if (isset($status) && $status == "active") {
    echo "checked='checked'";
} ?> value="active" />active<br/>
                                                <input type="radio" name="status" id="status" <?php if (isset($status) && $status == "inactive") {
    echo "checked='checked'";
} ?>  value="inactive"  />inactive
                                                <span><?php if (isset($error["status"])) { ?><span class="error"><?php echo $error["status"]; ?></span><?php } ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" name="test"  id="test" value="submit" />
                                            <i class="ace-icon fa fa-check bigger-110"></i>

                                            &nbsp; &nbsp; &nbsp;
                                            <button class="btn" type="reset">
                                                <i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
                                            </button>

                                        </div>
                                    </div>	
                                </form>		
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/ace-extra.min.js"></script>
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/chosen.jquery.min.js"></script>
        <script src="assets/js/fuelux.spinner.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/daterangepicker.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/jquery.knob.min.js"></script>
        <script src="assets/js/jquery.autosize.min.js"></script>
        <script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="assets/js/bootstrap-tag.min.js"></script> 
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>

        


    </body>
</html>
