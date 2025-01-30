<?php


function isEnable($recipe)
{
    if (array_key_exists("is_enabled", $recipe)) {
        $resultEnable = $recipe['is_enabled'];
    } else {
        $resultEnable = false;
    }
    return $resultEnable;
}

function getRecipes($recipes): array
{
    $recipesEnabled = [];
    foreach ($recipes as $recipe) {
        if (isEnable($recipe)) {
            $recipesEnabled[] = $recipe;
        }
    }
    return $recipesEnabled;
}

function displayAuthor($users, $authorEmail): string
{
    foreach ($users as $user) {
        if ($user['email'] === $authorEmail) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return "Recette non signée ..";
}


function redirectToUrl($url)
{
    header("location: {$url}" );
    exit();
}

function validateForm($data) {
    $errors = []; 
  
    if (empty($data['author']) || !filter_var($data['author'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email de l'auteur est invalide.";
    }


    if (empty(trim($data['title']))) {
        $errors[] = "Le titre est obligatoire.";
    }

 
    if (empty(trim($data['recipe']))) {
        $errors[] = "Le contenu de la recette est obligatoire.";
    }

    if (empty(trim($data['user_id'])) || !is_numeric($data['user_id'])) {
        $errors[] = "Le user_id est incorrect";
    }

    if (empty(trim($data['recipe_id'])) || !is_numeric($data['recipe_id'])) {
        $errors[] = "Le recipe_id est incorrect";
    }

    if (empty(trim($data['comment']))) {
        $errors[] = "Le contenu du commentaire est obligatoire, il ne peux être vide.";
    }

   
    $_SESSION['MESSAGE_ERROR'] = $errors;

    return $errors; // Retourne les erreurs pour un traitement ultérieur
}

function validateFormComment($data) {

    $errors = []; 

    if (empty(trim($data['user_id'])) || !is_numeric($data['user_id'])) {
        $errors[] = "Le user_id est incorrect";
    }

    if (empty(trim($data['recipe_id'])) || !is_numeric($data['recipe_id'])) {
        $errors[] = "Le recipe_id est incorrect";
    }

    if (empty(trim($data['comment']))) {
        $errors[] = "Le contenu du commentaire est obligatoire, il ne peux être vide.";
    }

   
    $_SESSION['MESSAGE_ERROR'] = $errors;

    return $errors; // Retourne les erreurs pour un traitement ultérieur
}
