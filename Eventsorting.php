
 <?php
require_once("session.php");
require_once("class.event.php");
require_once("includes/config.php");
require_once("category.php");
$event1 = new EVENT();
$db = new DATABASE();


	$requestData= $_REQUEST;
	//echo"<pre>";print_r($requestData);exit;
$columns = array(
	0 =>'Title',
	1 =>'Description',
	2 =>'Event_start_date',
	3 =>'Event_end_date',
	4 =>'Eventstatus',
	5 =>'TicketAmount',
	6 =>'categoryname'
	//7 =>'Address'
	);

$sql = "select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e left outer JOIN `category` as c ON e.category_id = c.category_id left outer JOIN `image_master` as i ON i.ID = e.ID";
$query = $db->connect()->prepare($sql);
$query->execute();
$test1 = $query->fetchALL(PDO::FETCH_ASSOC);
$totalData = $query->rowCount();
$totalFilterData = $totalData;

$sql = "select e.ID,e.Title,e.Description,e.Venue,e.latitude,e.longitude,e.Event_start_date,e.Event_end_date,e.Eventstatus,e.TicketAmount,e.Capacity,e.Booking_start_date,e.Booking_end_date,e.Address,e.status,e.category_id,c.categoryname,i.image,i.image_id from `event` as e left outer JOIN `category` as c ON e.category_id = c.category_id left outer JOIN `image_master` as i ON i.ID = e.ID where 1=1";
if( !empty($requestData['columns'][0]['search']['value']) ) {   
		$sql.=" AND ( Title LIKE '%".$requestData['columns'][0]['search']['value']."%'";    
	  
}
if(!empty($requestData['columns'][1]['search']['value']))
{
			$sql.=" OR Description LIKE '%".$requestData['columns'][1]['search']['value']."%' ";

}
if(!empty($requestData['columns'][2]['search']['value']))
{
			 $sql.=" OR Event_start_date LIKE '%".$requestData['columns'][2]['search']['value']."%'";
			 

}
if(!empty($requestData['columns'][3]['search']['value']))
{
			 $sql.=" OR Event_end_date LIKE '%".$requestData['columns'][3]['search']['value']."%'";

}
if(!empty($requestData['columns'][4]['search']['value']))
{
		    $sql.=" OR Eventstatus LIKE '%".$requestData['columns'][4]['search']['value']."%'";

}
if(!empty($requestData['columns'][5]['search']['value']))
{
		    $sql.=" OR TicketAmount LIKE '%".$requestData['columns'][5]['search']['value']."%'";

}
if(!empty($requestData['columns'][6]['search']['value']))
{
	    $sql.=" OR categoryname LIKE '%".$requestData['columns'][6]['search']['value']."%'";

}
// if(!empty($requestData['columns'][7]['search']['value']))
// {
// 	   $sql.=" OR Address LIKE '%".$requestData['columns'][7]['search']['value']."%')";

// }
$query = $db->connect()->prepare($sql);
$query->execute();
$test = $query->fetchALL(PDO::FETCH_ASSOC);
$totalData1 = $query->rowCount();
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."";
$query = $db->connect()->prepare($sql);
$query->execute();
$totalData2 = $query->rowCount();
$data = array();
$rowdata = $query->fetchALL(PDO::FETCH_ASSOC);
foreach($rowdata as $row)
{
	$totalData1 = array();
	$totalData1[] = $row["Title"];
	$totalData1[] = $row["Description"];
	$totalData1[] = $row["Event_start_date"];
	$totalData1[] = $row["Event_end_date"];
	$totalData1[] = $row["Eventstatus"];
	$totalData1[] = $row["TicketAmount"];
	$totalData1[] = $row["categoryname"];
	//$totalData1[] = $row["Address"];
	 $data[] = $totalData1;
	//echo"<pre>";print_r($totalData1);
}
//exit;
$jsondata = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFilterData ), 
			"data"            => $data  
	);
	echo json_encode($jsondata);
	?>