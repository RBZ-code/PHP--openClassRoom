<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/dataBaseConnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');


$postData = $_POST;


if (isset($postData['email']) && isset($postData['password'])) {
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['MESSAGE_ERROR'] = 'Votre Email n\'est pas valide';
    } else {
        $foundUser = false;
        foreach ($users as $user) {
            if ($user['email'] === $postData['email'] && $user['password'] === $postData['password']) {


                $_SESSION['LOGGED_USER'] = [
                    'email' => $postData['email'],
                    'full_name' => $user['full_name'],
                    'user_id' => $user['User_id'],
                ];
                
                $_SESSION['MESSAGE_SUCCESS'] = "Bonjour {$_SESSION['LOGGED_USER']['email']} et bienvenue sur le site !
    ✅";
                break;
            }
        }

        if (!$_SESSION['LOGGED_USER']) {
            $safemail = htmlspecialchars($postData['email'], ENT_QUOTES, 'UTF-8');
            $_SESSION['MESSAGE_ERROR'] = "L'email ou le mot de passe que vous avez renseigné est incorrect. {$safemail}";
        }
    }
}

redirectToUrl("index.php");
