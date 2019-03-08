<?php

require_once '..\dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;


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

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream();

	
}
else{
	echo "hrelp";
}

?>