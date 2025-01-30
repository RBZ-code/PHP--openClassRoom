<?php
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');

$sqlQuery = 'SELECT * FROM recipes WHERE is_enabled = :is_enabled';

$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute([

'is_enabled' => true,
]);
$recipes = $recipesStatement->fetchAll();

$sqlQuery = 'SELECT * FROM users';
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$users = $recipesStatement->fetchAll();

?>