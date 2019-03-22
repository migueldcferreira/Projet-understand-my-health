
<?php
/* Database connection start */
require('Bdd.php');
$db = Bdd::connect("BDD_TRADOCTEUR");



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 => 'MOT', 
	1 => 'DEFINITION',
	2 => 'DATE_MODIF'

);

// getting total number records without any search
$sql = "SELECT MOT, DEFINITION";
$sql.=" FROM TABLE_DEFINITION WHERE A_CONFIRMER=1";
$query=  $db->prepare($sql) ;
$query ->execute() or die("admin_def_data_1.php: get defs 1");
$totalData = $query->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT ID_DEFINITION, MOT, DEFINITION, DATE_MODIF";
$sql.=" FROM TABLE_DEFINITION WHERE A_CONFIRMER=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND MOT LIKE '%".$requestData['search']['value']."%' ";    
	

	
}
$query= $db->prepare($sql) ;
$query ->execute() or die("admin_def_data_1.php: get defs 2");
$totalFiltered = $query->rowCount(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query= $db->prepare($sql);
$query ->execute() or die("admin_def_data_1.php: get defs 3");

$data = array();
while( $row= $query->fetch() ) {  // preparing an array

	$nestedData=array(); 


	$nestedData[] = $row["MOT"];
	$nestedData[] = $row["DEFINITION"];
	$nestedData[] = $row["DATE_MODIF"];
	$nestedData[] = '<a href="ajouter.php?id='.$row["ID_DEFINITION"].'"> <button class="btn btn-success btn-sm tooltipsAdmin" title="Ajouter la définition"><i class="fas fa-check"></i></button> </a>
					<a href="modifier.php?id='.$row["ID_DEFINITION"].'">  <button class="btn btn-sm tooltipsAdmin enabled" title="Modifier cette définition"><i class="fa fa-edit"></i></button>      </a>
					<a href="supprimer_def.php?id='.$row["ID_DEFINITION"].'"> <button class="btn btn-danger btn-sm tooltipsAdmin enabled" title="Supprimer cette définition"><i class="fas fa-minus-circle"></i></button> </a>';

	
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
