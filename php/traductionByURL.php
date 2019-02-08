<!doctype html>
<html lang="fr">
  <head>
    <?php include("head.php"); ?>
		<link rel="stylesheet" href="../css/traduction.css" />
  </head>
  <body>

    <!--Container principal-->
      <?php include("menu.php"); ?>

<?php
	$textform = file_get_contents($_POST["testurl"]);

	/*****
		Source de la fonction strip_html_tags  : http://nadeausoftware.com/articles/2007/09/php_tip_how_strip_html_tags_web_page (code open source, licence BSD OSI)
		Utilise la fonction strip_tags() (fonction intégrée dans le langage php) qui va supprimer les balises HTML et PHP d'une chaîne.
		Ici, la fonction strip_html_tags() va effectuer un premier traitement sur contenu de la page web que l'utilisateur aura demandée à simplifier, il va :
		-->Supprimez les paires de balises HTML et le contenu inclus pour les styles, scripts, objets incorporés, etc.
		-->Ajoutez des sauts de ligne autour des balises de niveau bloc pour éviter les problèmes de jonction de mots après la suppression de la balise..
		
		En effet, la fonction strip_tags() utilisée toute seule va supprimer plus de contenu (pour nous, plus de texte) que voulu car elle va supprimer les balises ouvrante et fermante
		en laissant le code de style de page web et d'autres informations superflues, joint les mots à droite et à gauche de chaque balise supprimée.
	******/

function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}	


	$textform=strip_html_tags($textform);

	$textform = str_replace( array( '?', ',', '.', ':', '!', '\''), ' ', $textform ); 


	$liste= array("rhume", "gastro", "gastro-entérite", "pneumonie");
	$definition= array("Le rhume est causé par un virus. C'est une infection fréquente du nez et de la gorge nommée aussi rhinite virale ou aiguë.",
										"Abréviation de gastro-entérite, maladie qui résulte de l'inflammation de l'estomac ou des intestins due à un virus. Le malade souffre alors d'une diarrhée plus ou moins sévère.",
									 	"Gastro-entérite désigne une inflammation simultanée de la muqueuse de l'estomac et de celle des intestins.",
										" La pneumonie est une infection des poumons causée le plus souvent par un virus ou une bactérie.");
	$i=0;
	$listeMotsTrouves=array();
	$nbMotsTrouves=0;

	$mot = strtok($textform, " \n\t");

	while ($mot !== false)
	{
		$indice = -1;
		while($i<4)
		{
			if (strcasecmp($mot, $liste[$i])==0)
			{
				$indice = $i;
				//echo("le mot " . $liste[$i] . " a ete trouve dans votre chaine de caractere <br />");
				//On ajoute le mot de notre $liste[] dans la liste des mots trouves
				$listeMotsTrouves[]=$liste[$i];
				//echo("on place le mot dans une liste de mots trouves" . $listeMotsTrouves[$nbMotsTrouves] . "<br />");
				$nbMotsTrouves++;
			}
			$i++;
		}
		if($indice != -1)
		{
			echo '<span class="vocabulaire">
							<span class="expression">'.$mot.'</span>
							<span class="definition hidden">'.$definition[$indice].'</span>
						</span>';
		}
		else
		{
			echo "$mot ";
		}
		$mot = strtok(" \n\t");
		$i=0;
	}


?>

		<?php include("script_menu.php"); ?>
		<script type="text/javascript" src="../javascript/afficherDefinition.js"></script>
	</body>
</html>
