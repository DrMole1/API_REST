<?php

// On implémente le fichier api.php contenant les fonctions d'affichages et de récupération de la BDD
require_once("api.php");

//www.monsite.fr/formations
// => www.monsite.fr/index.php?demande=formations

//www.monsite.fr/formations/:categorie
//www.monsite.fr/formation/:id

try {
	if(!empty($_GET['demande'])) {    // S'il y a une demande renseignée

		// On explode selon le séparateur /
		$url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));

		switch ($url[0]) {
			case 'formations':   // Si le premier mot après le '/' est 'formations'
				if(empty($url[1])) 
				{
					getFormations();
				} else 
				{
					getFormationsByCategorie($url[1]);
				}
				break;
			case 'formation':   // Si le premier mot après le '/' est 'formation'
				if(!empty($url[1])) {
					getFormationById($url[1]);
				} else {
					throw new Exception("Vous n'avez pas renseigné le numéro de la formation.");
				}
				break;
			default: throw new Exception ("La demande n'est pas validée, vérifiez l'url.");
				break;
		}

	} else {
		throw new Exception ("Problème de récupération des données.");
	}
} catch(Exception $e) {      // S'il y a une erreur, on l'affiche
	$erreur = [
		"message" => $e->getMessage(),
		"code" => $e->getCode()
	];
	print_r($erreur);
}

?>