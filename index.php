<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</head>



<body class="d-flex flex-column min-vh-100">
    <?php require_once(__DIR__ . '\header.php'); ?>

    <?php include(__DIR__ . '\login.php')
    ?>

    <div class="container">
        <?php if (!empty($_SESSION['MESSAGE_ERROR'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['MESSAGE_ERROR']); ?></div>
            <?php unset($_SESSION['MESSAGE_ERROR']); // Nettoie les erreurs après affichage 
            ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['MESSAGE_SUCCESS'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['MESSAGE_SUCCESS']); ?></div>
            <?php unset($_SESSION['MESSAGE_SUCCESS']); // Nettoie les erreurs après affichage 
            ?>
        <?php endif; ?>
        <h1 class="p-5 text-center">Affichage des Recettes :</h1>
        <?php foreach (getRecipes($recipes) as $recipe) : ?>

            <article class="p-5">

                <h3><a href="recipes_read.php?id=<?php echo ($recipe['recipe_id']); ?>"><?php echo ($recipe['title']); ?></a></h3>
                <div><?php echo $recipe['recipe'] ?></div>
                <p><em><?php echo displayAuthor($users, $recipe['author']) ?></em></p>
                <?php if (isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']['email']) : ?>
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item"><a class="link-warning" href="recipes_update.php?id=<?php echo ($recipe['recipe_id']); ?>">Editer l'article</a></li>
                        <li class="list-group-item"><a class="link-danger" href="recipes_delete.php?id=<?php echo ($recipe['recipe_id']); ?>">Supprimer l'article</a></li>
                    </ul>
                <?php endif; ?>
            </article>

        <?php endforeach ?>
    </div>


    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>


</body>


</html>