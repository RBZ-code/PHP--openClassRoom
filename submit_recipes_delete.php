<?php
session_start();
$postDataId = $_POST['id'];

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');



$postDataId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($postDataId <= 0) {
    $_SESSION['MESSAGE_ERROR'] = "ID invalide ou manquant pour effectuer la suppression.";
    header('Location: index.php');
    exit();
}

$sqlQuery = "SELECT * FROM recipes WHERE recipe_id = :id";
$getRecipe = $mysqlClient->prepare($sqlQuery);
$getRecipe->execute([
    'id' => $postDataId,
]);

$recipe = $getRecipe->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    $_SESSION['MESSAGE_ERROR'] = "La recette demandée n'existe pas.";
    header('Location: index.php');
    exit();
}

if($recipe['author'] !== $_SESSION['LOGGED_USER']['email'])
{
    $_SESSION['MESSAGE_ERROR'] = "Vous n'avez pas les droits pour supprimer cette recette !!";
    header('location: index.php');
    die();
}

$sqlQuery = "DELETE FROM recipes WHERE recipe_id=:id";
$deleteRecipe = $mysqlClient->prepare($sqlQuery);
$deleteRecipe->execute([
    'id' => $postDataId,
]);

$_SESSION['MESSAGE_SUCCESS'] = "Votre Recette à était supprimé avec succes!";
header("location: index.php");
die();