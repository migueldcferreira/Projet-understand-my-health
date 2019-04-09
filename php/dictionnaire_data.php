
<?php
/* Database connection start */
require('Bdd.php');
$db = Bdd::connect("BDD_TRADOCTEUR");



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'MOT', 
	1 => 'DEFINITION'

);

// getting total number records without any search
$sql = "SELECT MOT, DEFINITION";
$sql.=" FROM TABLE_DEFINITION WHERE A_CONFIRMER=0 AND CLASSEMENT=1";
$sql.=" UNION DISTINCT SELECT MOT, '[Image]' AS DEFINITION";
$sql.=" FROM TABLE_LIEN_MOT_IMAGE WHERE AND CLASSEMENT=1";
$query=  $db->prepare($sql) ;
$query ->execute() or die("dictionnaire_data.php: get defs 1");
$totalData = $query->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT MOT, DEFINITION";
$sql.=" FROM TABLE_DEFINITION WHERE A_CONFIRMER=0 AND CLASSEMENT=1";
$sql.=" UNION DISTINCT SELECT MOT, '[Image]' AS DEFINITION";
$sql.=" FROM TABLE_LIEN_MOT_IMAGE WHERE AND CLASSEMENT=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND MOT LIKE '%".$requestData['search']['value']."%' ";    
	

	
}
$query= $db->prepare($sql) ;
$query ->execute() or die("dictionnaire_data.php: get defs 2");
$totalFiltered = $query->rowCount(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query= $db->prepare($sql);
$query ->execute() or die("dictionnaire_data.php: get defs 3");

$data = array();
while( $row= $query->fetch() ) {  // preparing an array

	$nestedData=array(); 

	//$nestedData[] = $row["MOT"];
	$nestedData[] = '<a href="dictionnaireIllustre.php?mot='.$row["MOT"].'">'.$row["MOT"].'</a>';
	$nestedData[] = $row["DEFINITION"];
	
	$data[] = $nestedData;

}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);


echo json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);  // send data as json format

?>
