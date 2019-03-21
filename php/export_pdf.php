<?php



require_once '../mpdf/vendor/autoload.php';




if (isset($_POST['simplifier']))
{

	$texte = htmlspecialchars_decode($_POST['texte']);
	$traduction = $_POST['traduction'];
	$html = "
	<head>
	 <style>
	 .page_jump {page-break-inside : auto;}
	 .pagebreak { page-break-before: always; }
	 </style>
	</head>
	<body>
		<div class='page_jump'>
		$texte
		</div>
		<div class='pagebreak'> </div>
		<div class='page_jump'>
		$traduction
		</div>
	</body>

	";


	// instantiate and use the mpdf class
	$mpdf = new ../Mpdf/Mpdf();
	
	 

	$mpdf->WriteHTML($html);

	 

	$mpdf->Output();
	exit;
		
}


?>