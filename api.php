<?php

define("URL", str_replace("index.php", "", (isset($_SERVER["HTTPS"])? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));


function getFormations() 
{
	$pdo = getConnexion();

	// Ecriture de la requête avec jointure
	$req = "SELECT s.Id, s.Name, s.Description, s.Image, c.Name as 'Category_Name' from skills s inner join categories c on s.Category_Id = c.Id";

	$stmt = $pdo->prepare($req);
	$stmt->execute();
	$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// On remanipule le chemin http de l'image
	for($i = 0; $i < count($skills); $i++)
	{
		$skills[$i]['Image'] = URL."images/".$skills[$i]["Image"];
	}

	$stmt->closeCursor();

	sendJSON($skills);
}


function getFormationsByCategorie($category) 
{
	$pdo = getConnexion();

	// Ecriture de la requête avec jointure
	$req = "SELECT s.Id, s.Name, s.Description, s.Image, c.Name as 'Category_Name', c.Id from skills s inner join categories c on s.Category_Id = c.Id WHERE c.Id = :nameCategory";
	$stmt = $pdo->prepare($req);

	// Lier chaque marqueur à une valeur
	$stmt->bindValue(':nameCategory', $category, PDO::PARAM_INT);

	$stmt->execute();
	$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// On remanipule le chemin http de l'image
	for($i = 0; $i < count($skills); $i++)
	{
		$skills[$i]['Image'] = URL."images/".$skills[$i]["Image"];
	}

	$stmt->closeCursor();
	
	sendJSON($skills);
}


function getFormationById($id) 
{
	$pdo = getConnexion();

	// Ecriture de la requête avec jointure
	$req = "SELECT s.Id, s.Name, s.Description, s.Image, c.Name as 'Category_Name', c.Id from skills s inner join categories c on s.Category_Id = c.Id WHERE s.Id = :id";
	$stmt = $pdo->prepare($req);

	// Lier chaque marqueur à une valeur
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);

	$stmt->execute();
	$skill = $stmt->fetch(PDO::FETCH_ASSOC);

	// On remanipule le chemin http de l'image
	$skill['Image'] = URL."images/".$skill["Image"];

	$stmt->closeCursor();
	
	sendJSON($skill);
} 


function getConnexion() 
{
	return new PDO("mysql:host=localhost;dbname=skills;charset=utf8", "root", "");
}


function sendJSON($info) 
{
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");
	echo json_encode($info, JSON_UNESCAPED_UNICODE);
}


?>