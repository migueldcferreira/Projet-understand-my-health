<? php
	$monfichier  =  fopen ( ' ../../maj.txt ' , ' r + ' );
	fputs ( $monfichier , ' 2 ' );
	fclose ( $monfichier );
	en-tête ( ' location: accueil.php ' );
? >
