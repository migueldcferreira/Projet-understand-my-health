
<?php
/* Database connection start */

$servername = "localhost";
$username = "root";
$password = "BDDTradocteur";
$dbname = "BDD_TRADOCTEUR";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
mysqli_set_charset($conn,'utf8');
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'MOT', 
	1 => 'DEFINITION'

);

// getting total number records without any search
$sql = "SELECT mot, definition";
$sql.=" FROM TABLE_DEFINITION";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT MOT, DEFINITION";
$sql.=" FROM TABLE_DEFINITION WHERE a_confirmer=0";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND MOT LIKE '".$requestData['search']['value']."%' ";    
	

	
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees 3");

$data = array();
while( $row= $query->fetch_array(MYSQLI_ASSOC) ) {  // preparing an array
	printf("yes");
	printf(" ");
	printf($row["MOT"]);
	printf(" ");
	printf($row["DEFINITION"]);
	printf("\n");
	$nestedData=array(); 

	$nestedData[] = $row["MOT"];
	$nestedData[] = $row["DEFINITION"];
	
	$data[] = json_encode(utf8_decode($nestedData));

}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

printf("thenwhat");
echo json_encode($json_data);  // send data as json format

?>
