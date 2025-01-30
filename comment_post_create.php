<?php
session_start();

$postData = $_POST;

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/functions.php');

$errors = validateFormComment($postData);


if (!empty($errors)) {
    redirectToUrl("recipes_read.php?id=". $postData['recipe_id']);
    exit();
}


$user_id = htmlspecialchars($postData['user_id']);
$recipe_id = htmlspecialchars($postData['recipe_id']);
$comment = htmlspecialchars($postData['comment']);
$review = htmlspecialchars($postData['review']);

$SQLquerry = "INSERT INTO comments(user_id, recipe_id, comment, review) VALUE(:user_id, :recipe_id, :comment, :review)";
$insertComment = $mysqlClient->prepare($SQLquerry);
$insertComment->execute([
    'user_id' => $user_id,
    'recipe_id' => $recipe_id,
    'comment' => $comment,
    'review' => $review,
]);


$_SESSION['MESSAGE_SUCCESS'] = "Votre Commentaire à était ajouté avec succes!";
if (empty($errors)) {
    redirectToUrl("recipes_read.php?id=$recipe_id");
    exit();
}
