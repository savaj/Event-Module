<?php
require_once("session.php");
require_once("class.event.php");
require_once("category.php");
require_once("includes/config.php");

$event = new EVENT();
$db = new DATABASE();
$start = 0;
$num_rec_per_page = 2;



if (isset($_GET["Page"])) {
    $page = $_GET["Page"];
    $start = ($page - 1) * $num_rec_per_page;

} else {
    $page = 1;

}


 $sql = $db->connect()->prepare("select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e left outer JOIN `category` as c ON e.category_id = c.category_id left outer JOIN `image_master` as i ON i.ID = e.ID LIMIT $start,$num_rec_per_page");
$sql->execute();
$userRow = $sql->fetchALL(PDO::FETCH_ASSOC);

if (isset($_POST["search"])) {
    $Title = $_POST["search"];
    $sql = $db->connect()->prepare("select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e left outer JOIN `category` as c ON e.category_id = c.category_id left outer JOIN `image_master` as i ON i.ID = e.ID where e.Title LIKE '%".$Title."%'");
    $sql->execute();
    $userRow = $sql->fetchALL(PDO::FETCH_ASSOC);
 }

if (isset($_GET['action']) && $_GET['action'] == "delete" && $_GET["ID"]) {
    $id = $_GET["ID"];
    $sql = "DELETE FROM `event` WHERE ID = '" . $id . "'";
    $stmt = $event->connect()->prepare($sql);
    $stmt->execute();
    $event->redirect("list-event.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Event-Savaj Admin</title>
        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id=":" />
        <script src="assets/js/ace-extra.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.12.3.js"></script>
        <style>
            .current{
                list-style: none;
            }
        <style>
                    .pagination {
                        display: inline-block;
                    }

                    .pagination a {
                        color: black;
                        float: left;
                        padding: 8px 16px;
                        text-decoration: none;
                    }

                    .pagination a.active {
                        background-color: #307ecc;
                        color: white;
                        border-radius: 5px;
                    }

                    .pagination a:hover:not(.active) {
                        background-color: #ddd;
                        border-radius: 5px;
                    }
                li.next {
                    float:right;
                }
                li.previous {
                    float:left;
                }
</style>
        <script type="text/javascript" language="javascript" >
            $(document).ready(function(){
                $(".search").keyup(function(){
                    var searchid = $(this).val();
                    var datastring = 'search='+searchid;
                    if(searchid !='')
                    {
                        $.ajax({
                            type: "POST",
                            url: "list-event.php",
                            "processing": true,
                            data: datastring,
                            cache: false,
                            success: function(data)
                            {
                            	 $("#result").html(data);
                                 $("#searchid").val(searchid);
                                 $("#searchid").focus();
                            }
                    });
                    }
                   	 return false;
                });

            });
        </script>

    </head>

    <body class="no-skin" id="result">
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
                            <li class="active">Event</li>
                        </ul>
                    </div>



                        <div class="page-header">
                            <h1>
								Event Management
                                <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
									Event
                                </small>
                                <a href="add-Event.php"><button class="table-header">Add Event</button></a>
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-12">


                                        <div class="clearfix">
                                            <div class="pull-right tableTools-container"></div>
                                        </div>
                                        <div class="table-header">
											Event list
                                        </div>

                                        <div align="center">
                                        	<label class="text">Title</label>
                                            <input type="text" class="search" id="searchid" placeholder="Search By Title"/>
                                           <button class="table-header" id="reset" type="reset" onclick="window.location.reload();">Reset</button>
                                            <div>
                                                <table class="display">
                                                    <tr>
                                                        <th class="center">
                                                            <label class="pos-rel">
                                                                <input type="checkbox" class="ace" />
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>
                                                        <th width="100">SerialNo</th>
                                                        <th width="70">Title</th>
                                                        <th width="50">Description</th>
                                                        <th>eventImage</th>
                                                        <th>Event_start_date</th>
                                                        <th>Event_end_date</th>
                                                        <th>Eventstatus</th>
                                                        <th>TicketAmount</th>
                                                        <th>CategoryName</th>
                                                        <th width="50">Address</th>
                                                        <th width="50">Status</th>
                                                        <th>Action</th>
                                                    </tr>


													<?php
													$count = 1;
													foreach ($userRow as $row) {
													    $test = unserialize($row["image"]);
													    if ($row["status"] == 0) {
													        $row["status"] = "active";
													    } else {
													        $row["status"] = "Inactive";
													    }
													    ?>
                                                        <tr class="eventerror">
                                                            <td class="center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                        <?php echo $count ?>
                                                            </td>
                                                            <td>
   																	 <?php echo $row["Title"]; ?>
                                                            </td>
                                                            <td><?php echo $row["Description"]; ?></td>

                                                            <td class="hidden-480">
                                                                <span class="label">
                                                                <?php for ($i = 0; $i < count($test); $i++) { ?>
                                                                        <img src="uploads/<?php echo $test[$i]; ?>" height="30" width="30" onclick="toggle(this)">
    <?php } ?>
                                                                </span>
                                                            </td>

                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["Event_start_date"]; ?></span>
                                                            </td>
                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["Event_end_date"]; ?></span>
                                                            </td>
                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["Eventstatus"]; ?></span>
                                                            </td>
                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["TicketAmount"]; ?></span>
                                                            </td>

                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["categoryname"]; ?></span>
                                                            </td>
                                                            <td class="hidden-480">
                                                                <span ><?php echo $row["Address"]; ?></span>
                                                            </td>
                                                            <td class="hidden-480">
                                                                <span><?php echo $row["status"]; ?></span>
                                                            </td>
                                                            <td>
                                                                <div class="hidden-sm hidden-xs action-buttons">
                                                                    <a class="green" href="add-Event.php?action=update&ID=<?php echo $row["ID"]; ?>">
                                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                    </a>

                                                                    <a class="red" href="list-event.php?action=delete&ID=<?php echo $row["ID"]; ?>">
                                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="hidden-md hidden-lg">
                                                                    <div class="inline pos-rel">
                                                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                        </button>

                                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                            <li>
                                                                                <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                                                                    <span class="blue">
                                                                                        <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                                    <span class="green">
                                                                                        <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                                    <span class="red">
                                                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
    <?php
    $count++;
}
?>

                                                </table>
                                                <div class="pagination">
<?php
$sql2 = $db->connect()->prepare("select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e left outer JOIN `category` as c ON e.category_id = c.category_id left outer JOIN `image_master` as i ON i.ID = e.ID");
$sql2->execute();
$fechdata = $sql2->fetchALL(PDO::FETCH_ASSOC);
$rowsdata = $sql2->rowCount();
$totalpages = ceil($rowsdata / $num_rec_per_page);

if ($page > 1) {
    echo "<li class='previous'><a href='?Page=" . ($page - 1) . "'class='button'>&laquo;</a></li>";
}
if ($page != $totalpages) {
    echo "<li class='next'><a href='?Page=" . ($page + 1) . "'class='button'>&raquo;</a></li>";
}
for ($i = 1; $i <= $totalpages; $i++) {
    if ($i == $page) {
        echo "<li><a href='?Page=" . $i . "' class='active'>" . $i . "</a></li>";
    } else {

        echo "<li><a href='?Page=" . $i . "'>" . $i . "</a></li>";
    }
}
?>
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

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">Silver</span>
							Copyright@silvertouch 2015-2016
                        </span>

                        &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div>

        <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.12.3.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>-->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>
    </body>
</html>
