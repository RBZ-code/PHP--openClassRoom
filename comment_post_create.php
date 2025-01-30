<?php
session_start();

$postData = $_POST;

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/functions.php');

$errors = validateFormComment($postData);


if (!empty($errors)) {
    redirectToUrl('comment_create.php');
    exit();
}


$user_id = htmlspecialchars($postData['user_id']);
$recipe_id = htmlspecialchars($postData['recipe_id']);
$comment = htmlspecialchars($postData['comment']);

$SQLquerry = "INSERT INTO comments(user_id, recipe_id, comment) VALUE(:user_id, :recipe_id, :comment)";
$insertComment = $mysqlClient->prepare($SQLquerry);
$insertComment->execute([
    'user_id' => $user_id,
    'recipe_id' => $recipe_id,
    'comment' => $comment,
]);


$_SESSION['MESSAGE_SUCCESS'] = "Votre Commentaire à était ajouté avec succes!";
if (empty($errors)) {
    redirectToUrl("recipes_read.php?id=$recipe_id");
    exit();
}
