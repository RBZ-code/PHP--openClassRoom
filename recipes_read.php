<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo ('La recette n\'existe pas');
    return;
}

// On récupère la recette
$retrieveRecipeStatement = $mysqlClient->prepare('SELECT r.* FROM recipes r WHERE r.recipe_id = :id ');
$retrieveRecipeStatement->execute([
    'id' => (int)$getData['id'],
]);
$recipe = $retrieveRecipeStatement->fetch();

if (!$recipe) {
    echo ('La recette n\'existe pas');
    return;
}


$retrieveRecipeStatement = $mysqlClient->prepare(
    'SELECT c.comment, u.full_name, r.title, c.review, DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date
FROM comments c 
JOIN users u ON c.user_id = u.User_id
JOIN recipes r ON c.recipe_id = r.recipe_id
WHERE c.recipe_id = :id
ORDER BY c.created_at DESC'
);
$retrieveRecipeStatement->execute([
    'id' => (int)$getData['id'],
]);
$comments = $retrieveRecipeStatement->fetchAll();




$sqlQuery = 'SELECT ROUND(AVG(c.review),1) as rating FROM recipes r LEFT JOIN comments c on r.recipe_id = c.recipe_id WHERE r.recipe_id = :recipe_id';

// Préparation
$averageRatingStatment = $mysqlClient->prepare($sqlQuery);

// Exécution
$averageRatingStatment->execute([
    'recipe_id' => (int)$getData['id'],
]);

$averageRating = $averageRatingStatment->fetch();

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - <?php echo ($recipe['title']); ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once(__DIR__ . '/header.php'); ?>
    <div class="container min-vh-80">
        <?php if (!empty($_SESSION['MESSAGE_SUCCESS'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['MESSAGE_SUCCESS']); ?></div>
            <?php unset($_SESSION['MESSAGE_SUCCESS']); // Nettoie les erreurs après affichage 
            ?>
        <?php endif; ?>

        <h1><?php echo ($recipe['title']); ?></h1>
        <div class="row">
            <article class="col">
                <?php echo ($recipe['recipe']); ?>
            </article>
            <aside class="col">
                <p><i>Contribuée par <?php echo ($recipe['author']); ?></i></p>
                <?php if ($averageRating !== null) : ?>
                    <p><b>Evaluée par la communauté à <?php echo($averageRating['rating']); ?> / 5</b></p>
                <?php else : ?>
                    <p><b>Aucune évaluation</b></p>
                <?php endif; ?>
            </aside>
        </div>
        </br>
        <?php include(__DIR__ . '/comment_create.php') ?>

        <h4>Commentaires</h4>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Recette</th>
                    <th scope="col">Commentaire</th>
                    <th scope="col">Note</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($comments)) { ?>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($comment['full_name']); ?></th>
                            <td><?php echo htmlspecialchars($comment['title']); ?></td>
                            <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                            <td><?php echo htmlspecialchars($comment['review']); ?></td>
                            <td><?php echo htmlspecialchars($comment['comment_date']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">
                            <div class="alert alert-danger" role="alert">
                                Pas de commentaire !
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>
</body>

</html>