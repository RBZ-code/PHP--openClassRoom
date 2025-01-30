<?php
session_start();


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
    <div class="container">
        <?php if (!empty($_SESSION['MESSAGE_ERROR']) && is_array($_SESSION['MESSAGE_ERROR'])): ?>
            <?php foreach ($_SESSION['MESSAGE_ERROR'] as $error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
            <?php unset($_SESSION['MESSAGE_ERROR']); // Nettoie les erreurs après affichage 
            ?>
        <?php endif; ?>
        <h1 class="text-center mt-5">Ajouter une recette</h1>
        <form action="submit_recipes_create.php" method="post">
            <?php if (isset($_SESSION['LOGGED_USER']['email'])): ?>
                <input type="email" class="form-control" id="email" name="author" aria-describedby="email-help" value="<?php echo $_SESSION['LOGGED_USER']['email']; ?>" hidden>
            <?php endif; ?>
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input class="form-control" placeholder="Titre" id="title" name="title"></input>
            </div>
            <div class="mb-3">
                <label for="recette" class="form-label">Contenue de la recette</label>
                <textarea class="form-control" id="recette" name="recipe"></textarea>
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="is_enabled">
                    <option selected value="1">Activé</option>
                    <option value="0">désactivé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <br />
    </div>
    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>
</body>


</html>