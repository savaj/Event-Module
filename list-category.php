<?php
require_once("session.php");
require_once("class.event.php");
require_once("category.php");
require_once("includes/config.php");
$event = new EVENT();
$db = new DATABASE();
$table = new CATEGORY();

$start = 0;
$num_rec_per_page = 5;
if(isset($_GET["category_id"]))
{
    $id1 = $_GET["category_id"];
    $start = ($id1-1)*$num_rec_per_page;
}
else{
    $id1 = 1;
}
$test = $db->connect()->prepare("select * from category LIMIT $start,$num_rec_per_page");
$test->execute();
$userRow = $test->fetchALL(PDO::FETCH_ASSOC);
if(isset($_POST["search"]))
{
    $categoryname = $_POST["search"];
    $test = $db->connect()->prepare("select * from category where categoryname LIKE '%".$categoryname."%'");
    $test->execute();
    $userRow = $test->fetchALL(PDO::FETCH_ASSOC);

}
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $id = $_GET["category_id"];
    $sql = "DELETE FROM `category` WHERE category_id =  '" . $id . "'";
    $stmt = $db->connect()->prepare($sql);
    $stmt->execute();
    $event->redirect("list-category.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Category - Ace Admin</title>

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
                input {
            width: 250px;
            height: 50px;
              }

                input,
                input::-webkit-input-placeholder {
                    font-size: 20px;
                    line-height: 2;
                }
                li.next {
                    float:right;
                }
                li.previous {
                    float:left;
                }
        </style>
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
</style>
        <script>
        $(function(){
            $(".search").keyup(function(){
                    var searchid = $(this).val();
                    var datastring = 'search='+searchid;
                    if(searchid !='')
                    {
                        $.ajax({
                            type: "POST",
                            url: "list-category.php",
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
                                <a href="#">Category Management</a>
                            </li>
                            <li class="active">Category</li>
                        </ul><!-- /.breadcrumb -->


                    </div>

                    <div class="page-content">


                        <div class="page-header">
                            <h1>
								Category Management
                                <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
									Category
                                </small>
                                <a href="add-Category.php"><button class="table-header">Add Category</button></a>
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
											Category list
                                        </div>

                                        <div align="center">

                                            <label class="text">Search with Category Name</label>
                                            <input type="text" class="search" id="searchid" placeholder="Search By Categoryname"/>
                                            <button class="table-header" id="reset" type="reset" onclick="window.location.reload();">Reset</button>
                                            <button class="table-header" type="submit" name="delete">DELETE</button>
                                            <div>
                                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="center">
                                                          <label class="pos-rel">
                                                                <input type="checkbox" class="ace" name="deletecategory[]"/>
                                                                <span class="lbl"></span>
                                                          </label>
                                                        </th>
                                                        <th>SerialNo</th>
                                                        <th>Categoryname</th>
                                                        <th>CategoryDescription</th>
                                                        <th class="hidden-480">CategoryImage</th>
                                                        <th class="hidden-480">Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                        <?php
                                                        $count = 1;
                                                        foreach ($userRow as $row) {
                                                            $id = $row["category_id"];
                                                            ?>
                                                        <tr>
                                                            <td class="center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace" name="deletecategory[]" value="<?php echo $id; ?>"/>
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                            <?php echo $count ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row["categoryname"]; ?>
                                                            </td>
                                                            <td><?php echo $row["categorydescription"]; ?></td>
                                                            <td class="hidden-480"><img src="uploads/<?php echo $row["categoryimage"]; ?>" height="50px" width="50"></td>


                                                            <td class="hidden-480">
                                                                <span class="label label-sm label-warning"><?php echo $row["status"]; ?></span>
                                                            </td>

                                                            <td>
                                                                <div class="hidden-sm hidden-xs action-buttons">
                                                                    <a class="green" href="add-Category.php?action=update&category_id=<?php echo $id ?>">
                                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                    </a>

                                                                    <a class="red" href="list-category.php?action=delete&category_id=<?php echo $id ?>">
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
                                                </tbody>
                                            </table>
                                            <div class="pagination">

                                            <?php
                                            $sql2 = $db->connect()->prepare("select * FROM `category`");
                                            $sql2->execute();
                                            $fetchdata = $sql2->fetchALL(PDO::FETCH_ASSOC);
                                            $rowsdata = $sql2->rowCount();
                                            $totalpages = ceil($rowsdata / $num_rec_per_page);

                                            if($id1 > 1)
                                            {
                                                 echo "<li class='previous'><a href='?category_id=" . ($id1 - 1) . "'class='button'>&laquo;</a></li>";
                                            }
                                            if($id1 != $totalpages)
                                            {
                                                 echo "<li class='next'><a href='?category_id=" . ($id1 + 1) . "'class='button'>&raquo;</a></li>";
                                            }
                                            for($i=1; $i<=$totalpages; $i++)
                                            {
                                                if($i==$id1)
                                                {
                                                   echo "<li><a href='?category_id=" . $i . "' class='active'>" . $i . "</a></li>";
                                                }
                                                else{
                                                   echo "<li><a href='?category_id=" . $i . "'>" . $i . "</a></li>";
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
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>
    </body>
</html>
