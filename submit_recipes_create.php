<?php
session_start();

$postData = $_POST;

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

if((int)$_POST['is_enabled'] === 1)
{
    $status = 'activé';
}
else{
    $status = 'Désactivé';
}

$errors = validateForm($postData);

if (!empty($errors)) {
    redirectToUrl('recipes_create.php');
    exit();
}

$title = htmlspecialchars($_POST['title']);
$author = htmlspecialchars($_POST['author']);
$recipe = htmlspecialchars($_POST['recipe']);
$is_enabled = htmlspecialchars($_POST['is_enabled']);

$sqlQuery = "INSERT INTO recipes(title, recipe, author, is_enabled) VALUE (:title, :recipe, :author, :is_enabled)";
$insertRecipe = $mysqlClient->prepare($sqlQuery);
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'author' => $author,
    'is_enabled' => $is_enabled,
])

?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>


<body class="d-flex flex-column min-vh-100">
    <?php require_once(__DIR__ . '/header.php'); ?>

    <div class="alert alert-success" role="alert">
        <p class="mb-0">Votre recette à était créée avec succes ! ✅</p>
    </div>
    <div class="container">
        <h1 class="p-5 text-center">Votre Recette</h1>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Rappel de votre recette</h3>
                <p class="card-text"><b>tître : </b><?php echo htmlspecialchars($_POST['title'])  ?></p>
                <p class="card-text"><b>Recette : </b> <?php echo htmlspecialchars($_POST['recipe']) ?></p>
                <p class="card-text"><b>Auteur : </b> <?php echo htmlspecialchars($_POST['author']) ?></p>
                <p class="card-text"><b>Status : </b> <?php echo htmlspecialchars($status) ?></p>
            </div>
        </div>


    </div>
    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>

</body>

</html>