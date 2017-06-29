<?php
error_reporting(0);
require_once("session.php");
require_once("class.event.php");
require_once("includes/config.php");
$event = new DATABASE();
$event1 = new EVENT();
 define ("MAX_SIZE","400");

if ((isset($_GET['action']) && $_GET['action'] == "update" && $_GET["ID"])) {
    $ID =$_GET["ID"];
    $test1 = $event->connect()->prepare("select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e JOIN `category` as c ON e.category_id = c.category_id  JOIN `image_master` as i ON i.ID = e.ID where e.ID='" . $ID . "' ORDER BY ID ");
    $test1->execute();
    $userRow = $test1->fetchALL(PDO::FETCH_ASSOC);
    foreach ($userRow as $row) {
        $title = $row["Title"];
        $description = $row["Description"];
        $Venue = $row["Venue"];
        $latitude = $row["latitude"];
        $longitude = $row["longitude"];
        $event_start_date = $row["Event_start_date"];
        $event_end_date = $row["Event_end_date"];
        $event_status = $row["Eventstatus"];
        $ticketamount = $row["TicketAmount"];
        $Capacity = $row["Capacity"];
        $booking_start_date = $row["Booking_start_date"];
        $booking_end_date = $row["Booking_end_date"];
        $Address = $row["Address"];
        $category_id = $row["category_id"];
        $image = unserialize($row["image"]);
        $status = $row["status"];
    }
    if (isset($_POST["test"]) && $_GET["ID"]) {
        $image = $_FILES['image']['name'];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $allowed = array('gif', 'png', 'jpg');
        $Address = $_POST["Address"];
        $status = $_POST["status"];
        $Capacity = $_POST["Capacity"];
        $category_name = $_POST["category_name"];
        $booking_start_date = $_POST["booking_start_date"];
        $booking_end_date = $_POST["booking_end_date"];
        $event_start_date = $_POST["event_start_date"];
        $event_end_date = $_POST["event_end_date"];
        $Venue = $_POST["Venue"];
        $event_status = $_POST["event_status"];
        $ticketamount = $_POST["ticketamount"];

        $status = $_POST["status"];
        $ID = $_GET["ID"];
        $allowed = array('gif', 'png', 'jpg');
        $image = $_FILES['image']['name'];
        $error = array();
        if (!empty($_FILES["image"]["name"])) {
            $error["image"] = "Invalid Extension";
        }

        if (empty($_POST['title'])) {
            $error['title'] = "Please Enter title";
        }
        if (empty($_POST['description'])) {
            $error['description'] = "Please Enter Description";
        }
        if (empty($_POST['booking_start_date'])) {
            $error['booking_start_date'] = "Please Enter Booking Start Date";
        }
        if (empty($_POST['booking_end_date'])) {
            $error['booking_end_date'] = "Please Enter Booking End Date";
        }
        if (empty($_POST['event_start_date'])) {
            $error['event_start_date'] = "Please Enter Event Start Date";
        }
        if (empty($_POST['event_end_date'])) {
            $error['event_end_date'] = "Please Enter Event End Date";
        }
        if (empty($_POST['Capacity'])) {
            $error['Capacity'] = "Please Enter Capacity";
        }
        if (empty($_POST['event_status'])) {
            $error['event_status'] = "Please Select EventStatus";
        }
        if (empty($_POST['Venue'])) {
            $error['Venue'] = "Please Enter Venue";
        }
        if (empty($_POST['status'])) {
            $error['status'] = "Please Enter Status";
        }
        if (empty($_POST['Address'])) {
            $error['Address'] = "Please Enter Address";
        }
        if (empty($_POST["category_name"])) {
            $error["category_name"] = "Please Enter Categoryname";
        }

        if (!empty($_FILES["image"]["name"])) {
            $sql2 = "UPDATE `event`  
  			 SET 	`Title`              = 	'" . $_POST["title"] . "',
  					`Description`        = 	'" . $_POST["description"] . "',
  			 		`Venue`              = 	'" . $_POST["Venue"] . "',
  			  		`Event_start_date`   =  '" . $_POST["event_start_date"] . "',
  			 		`Event_end_date`     = 	'" . $_POST["event_end_date"] . "',
  			 		`Eventstatus`        =  '" . $_POST["event_status"] . "',
  			 		`Ticketamount`       =  '" . $_POST["ticketamount"] . "',
  			 		`Capacity`           =  '" . $_POST["Capacity"] . "',                                            
  			        `Address`            =  '" . $_POST["Address"] . "',
  			        `Booking_start_date` =  '" . $_POST["booking_start_date"] . "',
                    `Booking_end_date`   =  '" . $_POST["booking_end_date"] . "',
                    `category_id`        =  '" . $_POST["category_name"] . "',
                    `Capacity`           =  '" . $_POST["Capacity"] . "',
                    `Eventstatus`        =  '" . $_POST["event_status"] . "',
                     `status`            = '" . $_POST["status"] . "' 
				 	  where ID = '" . $_GET["ID"] . "'";

            $test12 = $event->connect()->prepare($sql2);

            $test12->execute();
            $j = 0;
            $target_path = "uploads/";
            $image = $_FILES["image"]["name"];
            for ($i = 0; $i < count($image); $i++) {
                $test[$i] = basename($image[$i]);
                $tmp_name = $_FILES['image']['tmp_name'][$i];
                $validextensions = array("jpeg", "jpg", "png");
                $ext = explode('.', basename($_FILES['image']['name'][$i]));
                $file_extension = end($ext);

                $target_path = $target_path . $test[$i] . "." . $ext[count($ext) - 1];

                $j = $j + 1;
                if (($_FILES["image"]["size"][$i] < 2000000) && in_array($file_extension, $validextensions)) {
                    if (move_uploaded_file($tmp_name, $target_path)) {
                        echo $j . ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
                    } else {
                        echo $j . ').<span id="error">please try again!.</span><br/><br/>';
                    }
                } else {
                    echo $j . ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
                }
            }
            $test1 = serialize($test);
            if ($test[0] != "") {
                $sql3 = "UPDATE `image_master` SET `image` = '" . $test1 . "'
		    									where ID = '" . $_GET["ID"] . "'";
                $sql4 = $event->connect()->prepare($sql3);
                $sql4->execute();
                $event1->redirect("home.php");
            } else {

                $Update = "UPDATE `event`  
  			 SET `Title` = '" . $_POST["title"] . "',
  			 `Description` = '" . $_POST["description"] . "',
  			 `Venue` = '" . $_POST["Venue"] . "',
  			  `Event_start_date` = '" . $_POST["event_start_date"] . "',
  			 `Event_end_date` = '" . $_POST["event_end_date"] . "',
  			 `Eventstatus` = '" . $_POST["event_status"] . "',
  			 `Ticketamount` = '" . $_POST["ticketamount"] . "',
  			 `Capacity` = '" . $_POST["Capacity"] . "',                                            
  			 `Address` = '" . $_POST["Address"] . "',
  			 `Booking_start_date` = '" . $_POST["booking_start_date"] . "',
  			 `Booking_end_date` = '" . $_POST["booking_end_date"] . "',
  			 `category_id` = '" . $_POST["category_name"] . "',
  			 `Capacity` = '" . $_POST["Capacity"] . "',
  			 	`Eventstatus` = '" . $_POST["event_status"] . "',
      			 `status` = '" . $_POST["status"] . "' 
				 		where ID = '" . $_GET["ID"] . "'";

                $testdata = $event->connect()->prepare($Update);

                $testdata->execute();
                $event1->redirect("list-Event.php");
            }
        }
    }
} else if (isset($_POST["test"]) && isset($_POST)) {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $allowed = array('gif', 'png', 'jpg');
    $image = $_FILES["image"]["name"];
    $Address = $_POST["Address"];
    $status = $_POST["status"];
    $Capacity = $_POST["Capacity"];
    $category_name = $_POST["category_name"];
    $booking_start_date = $_POST["booking_start_date"];
    $booking_end_date = $_POST["booking_end_date"];
    $event_start_date = $_POST["event_start_date"];
    $event_end_date = $_POST["event_end_date"];
    $Venue = $_POST["Venue"];
    $event_status = $_POST["event_status"];
    $ticketamount = $_POST["ticketamount"];
    // $latlong    =   get_lat_long($Address); // create a function with the name "get_lat_long" given as below
    //    $map    = explode(',' ,$latlong);
    //    $let         =   $map[0];
    //    $long    =   $map[1]; 
    $error = array();
    if (empty($_FILES["image"]["name"])) {
        $error["image"] = "Please Select Image";
    }
    if (empty($_POST['title'])) {
        $error['title'] = "Please Enter Title";
    }
    if (empty($_POST['description'])) {
        $error['description'] = "Please Enter Description";
    }
    if (empty($_POST['booking_start_date'])) {
        $error['booking_start_date'] = "Please Enter Booking Start Date";
    }
    if (empty($_POST['booking_end_date'])) {
        $error['booking_end_date'] = "Please Enter Booking End Date";
    }
    if (empty($_POST['event_start_date'])) {
        $error['event_start_date'] = "Please Enter Event Start Date";
    }
    if (empty($_POST['event_end_date'])) {
        $error['event_end_date'] = "Please Enter Event End Date";
    }
    if (empty($_POST['Capacity'])) {
        $error['Capacity'] = "Please Enter Capacity";
    }
    if (empty($_POST['event_status'])) {
        $error['event_status'] = "Please Select EventStatus";
    }
    if (empty($_POST['Venue'])) {
        $error['Venue'] = "Please Enter Venue";
    }
    if (empty($_POST['status'])) {
        $error['status'] = "Please Enter Status";
    }
    if (empty($_POST['Address'])) {
        $error['Address'] = "Please Enter Address";
    }
    if (empty($_POST["category_name"])) {
        $error["category_name"] = "Please Enter Categoryname";
    }
     if (empty($_FILES["image"]["name"])) {
        $error["image"] = "Please Select Image";
    }

    if (empty($error)) {
        $lastid = $event1->add($title, $description, $Venue, $event_start_date, $event_end_date, $ticketamount, $event_status, $Capacity, $booking_start_date, $booking_end_date, $category_name, $Address, $status);
        if ($lastid > 0) {
            $j = 0;
                      $target_path = "uploads/original/";
                      $target_path1 = "uploads/small/";
                     for ($i = 0; $i < count($_FILES['image']['name']); $i++) {

                       $image[$i] = basename($_FILES['image']['name'][$i]);
                        $uploadedfile = $_FILES['image']['tmp_name'][$i];
                        if($image[$i])
                        {
                            $validextensions = array("jpeg", "jpg", "png");
                            $ext = explode('.', basename($_FILES['image']['name'][$i]));
                            $file_extension = end($ext);
                        if (($ext[count($ext) - 1] != "jpg") && ($ext[count($ext) - 1] != "jpeg") 
                        && ($ext[count($ext) - 1] != "png") && ($ext[count($ext) - 1] != "gif")) 
                        {
                            echo ' Unknown Image extension ';
                              
                        }
                        else{
                                
                              $size=filesize($_FILES['image']['tmp_name']);
                            if($size > MAX_SIZE*1024)
                            {
                                echo "You have exceeded the size limit";
                            }
                             if($validextensions == "jpeg" || $validextensions == "jpg")
                            {
                               $uploadedfile = $_FILES['image']['tmp_name'][$i]; 
                               $src = imagecreatefromjpeg($uploadedfile);
                               
                            }
                            if($validextensions == "png"){
                               $uploadedfile = $_FILES['image']['tmp_name'][$i];
                               $src = imagecreatefrompng($uploadedfile);
                            }
                             
                            list($width,$height)=getimagesize($uploadedfile);

                            $newwidth=60;
                            $newheight=($height/$width)*$newwidth;
                            $tmp=imagecreatetruecolor($newwidth,$newheight);
                           
                            $newwidth1=25;
                            $newheight1=($height/$width)*$newwidth1;
                            $tmp1=imagecreatetruecolor($newwidth1,$newheight1);

                            imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);

                            imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, $width,$height);

                            
                            $filename = $target_path. $image[$i];
                            $filename1 = $target_path1. $image[$i];
                                

                              imagejpeg($tmp,$filename,100);
                              imagejpeg($tmp1,$filename1,100);

                                 imagedestroy($src);
                                 imagedestroy($tmp);
                                 imagedestroy($tmp1);
                                  $j = $j + 1;
                                // echo $_FILES["image"]["size"][$i];exit;
                      if ($_FILES["image"]["size"][$i]<20000000 && 
                        in_array($file_extension, $validextensions)) {
                    if (move_uploaded_file($uploadedfile,  $filename)) {
                        echo $j . ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
                    }
                     if (move_uploaded_file($uploadedfile, $filename1)) {
                        echo $j . ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
                    }
                     else {
                        echo $j . ').<span id="error">please try again!.</span><br/><br/>';
                    }
                } else {
                    echo $j . ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
                }                  
            }  
                       
              }           
              
            }
                  $test = serialize($image);
                 
                 $sql1 = "INSERT INTO `image_master`(`image`,`ID`) VALUES";
                 $sql1 .= "('" . $test . "','" . $lastid . "'),";
                 $sql1 = rtrim($sql1, ',');
                 $stmt = $event->connect()->prepare($sql1);
                 $stmt->execute();
            if ($stmt) {
                echo "successfully";
            } else {
                echo "Not successfully";
            }    
            $event1->redirect("list-Event.php");    
        }
    }
} 
else if (isset($_GET['action']) && $_GET['action'] == "delete" && $_GET["image_id"]) {
    $id = $_GET["image_id"];
    $sql = "DELETE FROM `image_master` where image_id = '" . $id . "'";
    $stmt = $event->connect()->prepare($sql);
    $stmt->execute();
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

            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
            #map {
                height: 100%;
            }
            #floating-panel {
                position: absolute;
                top: 10px;
                left: 25%;
                z-index: 5;
                background-color: #fff;
                padding: 5px;
                border: 1px solid #999;
                text-align: center;
                font-family: 'Roboto','sans-serif';
                line-height: 30px;
                padding-left: 10px;
            }
            }
        </style>

        <script type="text/javascript">
		   
            $(function(){
                $("#test").click(function(){
                    $("#myform").valid();
                });
                $("#myform").validate({
                    rules: {
                        title: {
                            required: true
                        },
                        description: {
                            required: true
                        },
                        Venue: {
                            required: true
                        },
                        image: {
                           required: true                
                         },
                        event_start_date: {
                            required: true
                        },
                        event_end_date: {
                            required: true
                        },
                        ticketamount: {
                            required: true
                        },
                        Capacity: {
                            required: true
                        },
                        booking_start_date: {
                            required: true
                        },
                        booking_end_date: {
                            required: true
                        },
                        Address: {
                            required: true
                        },
                        status: {
                            required: true
                        },
                        category_name: {
                            required: true
                        }
                    },
                    messages: {
                        title: {
                            required: "Please Enter Title"
                        },
                        description: {
                            required: "Please Enter Description"
                        },
                        Venue: {
                            required: "Please Enter Venue"
                        },
                        image: {
                            required: "Please Select Image"
                        },
                        event_start_date: {
                            required: "Please Enter Start Date"
                        },
                        event_end_date: {
                            required: "Please Enter End Date"
                        },
                        ticketamount: {
                            required: "Please select Ticketamount"
                        },
                        Capacity: {
                            required: "Please Enter Capacity"
                        },
                        booking_start_date: {
                            required: "Please Enter Booking Start Date"
                        },
                        booking_end_date: {
                            required:  "Please Enter Booking End Date"
                        },
                        Address: {
                            required: "Please Enter Address"
                        },
                        status: {
                            required: "Please Select Status"
                        },
                        category_name : {
                            required: "please Select Category name"
                        }
                    }
                });
            });	   	

            $(function(){

                $(".ticker").click(function(){
                    if($("#tickeramount").is(":checked")){
                        $("#dvreport").show();
                    }
                    else{
                        $("#dvreport").hide();
                    }
                });
            });
           
            $(function(){
                $("#test").hide();
                $("#test1").hide();
            });
            $(function(){
                $("#add_more").click(function(){
                    var max = 100;
                    var table = $("#add_more").closest('table');
                    if(table.find('input:file').length < max)
                    {
                        table.append('<tr><td><input name="image[]" type="file" id="image" /></td></tr>');
                    }				
                });
                 
            });

        </script>

        <script>

            $(document).ready(function(){

                $("#event_start_date").datepicker
                ({

                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(selected) 
                    {

                        $("#event_end_date").datepicker("option","minDate", selected)

                    }

                });

                $("#event_end_date").datepicker
                ({ 

                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',

                    onSelect: function(selected) {

                        $("#event_start_date").datepicker("option","maxDate", selected)

                    }

                }); 

            });
            $(document).ready(function(){

                $("#booking_start_date").datepicker({

                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(selected) {
                        $("#booking_end_date").datepicker("option","minDate", selected)
                    }

                });

                $("#booking_end_date").datepicker({ 

                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',

                    onSelect: function(selected) {
                        $("#booking_start_date").datepicker("option","maxDate", selected)
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
                                <a href="#">Event Management</a>
                            </li>
                            <li class="active">ADD Event</li>
                        </ul>
                    </div>

                    <div class="page-content">
                        <div class="page-header">
                            <h1>
								Event Management
                                <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
									ADD Event
                                </small>
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <form class="form-horizontal" role="form" name="myform" id="myform" method="POST" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Title </label>

                                        <div class="col-sm-9">
                                            <input type="text" id="form-field-1" name="title" value="<?php if (isset($title)) {
    echo $title;
} ?>" placeholder="title" class="col-xs-10 col-sm-5" />
                                            <span><?php if (isset($error["title"])) { ?><span class="error"><?php echo $error["title"]; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image </label>

                                        <div class="col-sm-9">
                                            <table>
                                                <tr>
                                 <?php if (isset($image)) {    ?>
                                    <?php for ($i = 0; $i < count($image); $i++) { ?>
                                                            <td><input name="image[]" type="file" id="image" /></td>		
                                                            <td><img src = "../AdminModule/uploads/<?php echo ($image[$i]); ?>" width="50" height="50" /></td>	
				
                                     <?php } ?>
                                <?php } else { ?>
                                                        <td><input name="image[]" type="file" id="image" /></td>
                                                        <td><input type="button" name="add_more" id="add_more" class="upload" value="Add More Files"/></td>
                                                       
                                                        
<?php } ?>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="space-4"></div>
                                    <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description</label>

                                    <div class="col-sm-9">
                                            <input type="text"  name="description" id="description" value="<?php if (isset($description)) {
    echo $description;
} ?>" class="col-xs-10 col-sm-5" />
                                            <span><?php if (isset($error["description"])) { ?><span class="error"><?php echo $error["description"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>

                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Venue</label>

                                        <div class="col-sm-9">
                                            <input type="text"  name="Venue" id="Venue" value="<?php if (isset($Venue)) {
    echo $Venue;
} ?>" class="col-xs-10 col-sm-5" />
                                            <span><?php if (isset($error["Venue"])) { ?><span class="error"><?php echo $error["Venue"]; ?></span><?php } ?></span>
                                        </div>
                                    </div>

                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Event Start Date</label>

                                        <div class="col-sm-9">
                                            <input type="text"  id="event_start_date" name="event_start_date" value="<?php if (isset($event_start_date)) {
    echo $event_start_date;
} ?>" class="col-xs-10 col-sm-5"  />
                                            <span><?php if (isset($error["event_start_date"])) { ?><span class="error"><?php echo $error["event_start_date"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>

                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Event End Date</label>

                                        <div class="col-sm-9">
                                            <input type="text"  id="event_end_date" name="event_end_date" value="<?php if (isset($event_end_date)) {
                                                        echo $event_end_date;
                                                    } ?>" class="col-xs-10 col-sm-5"  />
                                            <span><?php if (isset($error["event_end_date"])) { ?><span class="error"><?php echo $error["event_end_date"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address</label>

                                        <div class="col-sm-9">
                                            <textarea rows="4" cols="20" name="Address" id="Address"  onkeyup="findAddress()"><?php if (isset($Address)) {
                                                        echo $Address;
                                                    } ?></textarea>

                                            <span><?php if (isset($error['Address'])) { ?><span class="error"><?php echo $error['Address']; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group"> 

                                        <div class="col-sm-9" id="test" >
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Latitude</label>

                                            <input type="text"  id="latitude" name="latitude" class="col-xs-10 col-sm-5"  />

                                            <span><?php if (isset($error['latitude'])) { ?><span class="error"><?php echo $error['latitude']; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group" >

                                        <div class="col-sm-9" id="test1">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Longitude</label>

                                            <input type="text"  id="longitude" name="longitude" class="col-xs-10 col-sm-5"  />

                                            <span><?php if (isset($error['longitude'])) { ?><span class="error"><?php echo $error['longitude']; ?></span><?php } ?></span>
                                        </div>
                                    </div>


                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Openfor</label>

                                        <div class="col-sm-9">
                                            <div><input type="radio" id="form-field-1" id="event_status" name="event_status" <?php if (isset($event_status) && $event_status == "public")
                                                        echo "checked='checked'"; ?>  value="public" class="col-xs-10 col-sm-5"  />Public<br/>
                                                <input type="radio" id="form-field-1" id="event_status" name="event_status" <?php if (isset($event_status) && $event_status == "private")
                                                        echo "checked='checked'"; ?> value="private" class="col-xs-10 col-sm-5"  />Private</div>
                                            <span><?php if (isset($error["event_status"])) { ?><span class="error"><?php echo $error["event_status"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>
                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Ticket Amount</label>
                                        <div class="col-sm-9">

                                            <div><input type="radio" name="tickeramount" id="tickeramount" <?php if (isset($ticketamount) && $ticketamount != "")
                                                        echo "checked='checked'"; ?> class="ticker" value="Paid">Paid<br/>
                                                <input type="radio" name="tickeramount" id="tickeramount" <?php if (isset($ticketamount) && $ticketamount == "0.000000")
                                                        echo "checked='checked'"; ?> class="ticker" value="free" >free</div>
                                            <span><?php if (isset($error["ticketamount"])) { ?><span class="error"><?php echo $error["ticketamount"]; ?></span><?php } ?></span>

                                        </div>

                                        <div class="col-sm-9" id="dvreport" style="display:none" >
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Ticket Amount</label>
                                            <input type="number" id="form-field-1" id="ticketamount"  name="ticketamount" class="col-xs-10 col-sm-5" value="<?php if (isset($ticketamount)) {
                                                        echo $ticketamount;
                                                    } ?>" />
                                        </div>
                                    </div>

                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Capacity</label>

                                        <div class="col-sm-9">
                                            <input type="number"  id="Capacity" name="Capacity" value="<?php if (isset($Capacity)) {
                                                        echo $Capacity;
                                                    } ?>" class="col-xs-10 col-sm-5"  />
                                            <span><?php if (isset($error["Capacity"])) { ?><span class="error"><?php echo $error["Capacity"]; ?></span><?php } ?></span>

                                        </div>

                                    </div>


                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Booking Start Date</label>

                                        <div class="col-sm-9">
                                            <input type="text"  id="booking_start_date" name="booking_start_date" value="<?php if (isset($booking_start_date)) {
                                                        echo $booking_start_date;
                                                    } ?>" class="col-xs-10 col-sm-5"  />
                                            <span><?php if (isset($error["booking_start_date"])) { ?><span class="error"><?php echo $error["booking_start_date"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Booking End Date</label>

                                        <div class="col-sm-9">
                                            <input type="text"  id="booking_end_date" name="booking_end_date" value="<?php if (isset($booking_end_date)) {
                                                        echo $booking_end_date;
                                                    } ?>" class="col-xs-10 col-sm-5"  />
                                            <span><?php if (isset($error["booking_end_date"])) { ?><span class="error"><?php echo $error["booking_end_date"]; ?></span><?php } ?></span>

                                        </div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="form-group">

                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Category</label>

                                        <div class="col-sm-9">
                                        <?php
                                        $Category = $event->connect()->prepare("SELECT c.category_id ,c.categoryname  FROM `category` as c");
                                        $Category->execute();
                                        $userRow1 = $Category->fetchALL(PDO::FETCH_ASSOC);
                                        ?>
                                            <select name= "category_name" id="category_name">
                                                <option value="">select</option>
<?php foreach ($userRow1 as $row1) { ?>
                                                    <option value="<?php echo $row1["category_id"]; ?>" <?php if (isset($category_id)) {
        if ($category_id == $row1["category_id"]) {
            echo 'selected';
        }
    } ?>  ><?php echo $row1['categoryname']; ?></option>
<?php } ?></select>
                                            <span><?php if (isset($error["category_id"])) { ?><span><?php echo $error["category_id"]; ?></span><?php } ?></span>
                                        </div>
                                    </div>
                                    <div class="space-4"></div>


                                    <div class="space-4"></div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status</label>

                                        <div class="col-sm-9">
                                            <div>
                                                <input type="radio" name="status" id="status" <?php if (isset($status) && $status == "0")
    echo "checked='checked'"; ?> value="active" />active<br/>
                                                <input type="radio" name="status" id="status" <?php if (isset($status) && $status == "1")
    echo "checked='checked'"; ?> value="inactive" />inactive<br/>
                                                <span><?php if (isset($error['status'])) { ?><span class="error"><?php echo $error['status']; ?></span><?php } ?></span>

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
