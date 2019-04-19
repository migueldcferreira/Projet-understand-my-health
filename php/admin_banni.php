
<?php
/* Database connection start */

require('Bdd.php');
$db = Bdd::connect("BDD_TRADOCTEUR");



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

	0 => 'NOM',
	1 => 'PRENOM',
	2 => 'ADRESSE_MAIL',
	3 => 'RANG',
	4 => 'DATE_DERNIERE_CONNEXION',
	5 => 'RATIO'


);

// getting total number records without any search
$sql = "SELECT ID_UTILISATEUR,NOM,PRENOM,ADRESSE_MAIL,RANG,DATE_DERNIERE_CONNEXION";
$sql.=" FROM TABLE_UTILISATEUR WHERE ACTIF=0  ";
$query=  $db->prepare($sql) ;
$query ->execute() or die("admin_membres_data_su.php: get defs 1");
$totalData = $query->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT ID_UTILISATEUR,NOM,PRENOM,ADRESSE_MAIL,RANG,DATE_DERNIERE_CONNEXION, NB_DEF_ACCEPTEE, NB_DEF_REFUSEE, COALESCE(((NB_DEF_ACCEPTEE)/NULLIF(NB_DEF_REFUSEE + NB_DEF_ACCEPTEE, 0) * 100), 50) AS RATIO";
$sql.=" FROM TABLE_UTILISATEUR WHERE ACTIF=0 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( NOM LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR PRENOM LIKE '%".$requestData['search']['value']."%' ";  
	$sql.=" OR ADRESSE_MAIL LIKE '%".$requestData['search']['value']."%') ";   
	

	
}
$query= $db->prepare($sql) ;
$query ->execute() or die("admin_membres_data_su.php: get defs 2");
$totalFiltered = $query->rowCount(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query= $db->prepare($sql);
$query ->execute() or die("admin_membres_data_su.php: get defs 3");

$data = array();
while( $row= $query->fetch() ) {  // preparing an array

	$nestedData=array(); 

	$nestedData[] = $row["NOM"];
	$nestedData[] = $row["PRENOM"];
	$nestedData[] = $row["ADRESSE_MAIL"];
	$nestedData[] = $row["RANG"];
	$nestedData[] = $row["DATE_DERNIERE_CONNEXION"];

	$nombre_total_def = $row["NB_DEF_ACCEPTEE"] + $row["NB_DEF_REFUSEE"];
    //au depart les utilisateurs ont un ratio neutre ( 0/0 (50%))

	$ratio = $row["NB_DEF_ACCEPTEE"].'/'.$nombre_total_def. ' ('. round($row["RATIO"]). '%)' ; //on arondit au centième près
	
	$nestedData[] = $ratio;

	if ($row["RANG"]=="admin"){
		$nestedData[] = '<a href="deban.php?id='.$row["ID_UTILISATEUR"].'"> <button class="btn btn-success btn-sm tooltipsAdmin " title="Débannir cet administrateur"><i class="fa fa-retweet"></i></button></a>
		';
	}
	else{
		$nestedData[] = '<a href="deban.php?id='.$row["ID_UTILISATEUR"].'"> <button class="btn btn-success btn-sm tooltipsAdmin " title="Débannir ce membre"><i class="fa fa-retweet"></i> </button> </a>
		';
	}
	
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
