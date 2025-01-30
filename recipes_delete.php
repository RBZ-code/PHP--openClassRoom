<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');


$getDataId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($getDataId <= 0) {
    die("ID invalide");
}





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
    <?php if (!empty($_SESSION['MESSAGE_ERROR']) && is_array($_SESSION['MESSAGE_ERROR'])): ?>
        <?php foreach ($_SESSION['MESSAGE_ERROR'] as $error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
        <?php unset($_SESSION['MESSAGE_ERROR']); // Nettoie les erreurs après affichage 
        ?>
    <?php endif; ?>
    <div class="container text-center mt-5">
        <div class="card shadow-lg p-5">
            <h1 class="text-danger">Supprimer la Recette</h1>
            <p class="mt-4">Êtes-vous sûr de vouloir supprimer cette recette ? Cette action est irréversible.</p>
            <form action="submit_recipes_delete.php" method="post" class="mt-4">
                <input type="hidden" name="id" value="<?php echo $getDataId; ?>">

                <button type="submit" class="btn btn-lg btn-danger px-5 py-3 mt-3">
                    <i class="bi bi-trash-fill"></i> Supprimer
                </button>
                <a href="index.php" class="btn btn-lg btn-secondary px-5 py-3 mt-3">Annuler</a>
            </form>
        </div>
    </div>
    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>
</body>


</html>