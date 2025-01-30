<?php

session_start();

$postData = $_POST;
$succes = false;

function generateDir(int $n): string
{
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $dir = "";
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $dir .= $characters[$index];
    }
    return $dir;
}


if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    if ($_FILES['file']['size'] > 1000000) {
        echo 'Le fichier est trop lourd pour être upload';
        return;
    }
    $fileInfo = pathinfo($_FILES['file']['name']);
    // var_dump($fileInfo);
    $extension = $fileInfo['extension'];
    $alowedExtension = ["jpeg", "gif", 'jpg', 'png'];

    if (!in_array($extension, $alowedExtension)) {
        echo 'L\'extension de votre fichier n\'est pas pris en comtpe';
        return;
    }

    $path = __DIR__ . '/upload';
    // var_dump($path);
    if (!is_dir($path)) {
        echo 'Le chemin de reception du fichier n\'a pas était trouvé';
        return;
    }
    $imagePath = $path . '/' . generateDir(10) . $_FILES['file']["name"];

    move_uploaded_file($_FILES['file']['tmp_name'], $imagePath);
    $succes = true;
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
    <?php

    if (!isset($postData['email']) || !isset($postData['message']) || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL) || trim($postData['message']) === '') {
        echo 'L\'email et le message doivent être conformes pour soumettre le formulaire !! ';
        return;
    }
    ?>
    <div class="container">
        <h1 class="p-5 text-center">Votre message</h1>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Rappel de vos informations</h3>
                <p class="card-text"><b>Email : </b><?php echo htmlspecialchars($_POST['email'])  ?></p>
                <p class="card-text"><b>Message : </b> <?php echo htmlspecialchars($_POST['message']) ?></p>
            </div>
        </div>
        <?php if ($succes) : ?>
            <div class="alert alert-success" role="alert">
                <p>Le fichier a était envoyé avec succes ! ✅</p>
            </div>
        <?php endif ?>
    </div>
    <?php require_once(__DIR__ . '/pied_de_page.php'); ?>

</body>

</html>