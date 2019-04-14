<?php
/* Database connection start */
require('Bdd.php');
$db = Bdd::connect("BDD_TRADOCTEUR");
// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
$columns = array(
  // datatable column index  => database column name
  0 => 'MOT',
  1 => 'FREQUENCE'
);
// getting total number records without any search
$sql = "SELECT MOT, FREQUENCE";
$sql.=" FROM TABLE_PROPOSITION_MOT WHERE MOT_FACILE=0";
$query=  $db->prepare($sql) ;
$query ->execute() or die("proposition_data.php: get defs 1");
$totalData = $query->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
$sql = "SELECT MOT, FREQUENCE";
$sql.=" FROM TABLE_PROPOSITION_MOT WHERE MOT_FACILE=0";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND MOT LIKE '%".$requestData['search']['value']."%' ";


}
$query= $db->prepare($sql) ;
$query ->execute() or die("proposition_data.php: get defs 2");
$totalFiltered = $query->rowCount(); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query= $db->prepare($sql);
$query ->execute() or die("proposition_data.php: get defs 3");
$data = array();
while( $row= $query->fetch() ) {  // preparing an array
  $nestedData=array();
  //$nestedData[] = $row["MOT"];
  $nestedData[] = $row["MOT"];
  $nestedData[] = $row["FREQUENCE"];
  $nestedData[] = '<a href="proposer_definition_mot.php?mot='.$row["MOT"].'"><button class="btn btn-primary btn-sm tooltipsAdmin " title="Définir ce mot"><i class="fas fa-pencil-alt"></i></button></a>'
                    .'<a href="proposer_definition_mot.php?facile='.$row["MOT"].'"><button class="btn btn-danger btn-sm tooltipsAdmin " title="Définir ce mot"><i class="fas fa-snowplow"></i></button></a>';

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
