<?php

?>
<?php if (isset($_SESSION['LOGGED_USER'])) : ?>
    <?php if (!empty($_SESSION['MESSAGE_ERROR']) && is_array($_SESSION['MESSAGE_ERROR'])): ?>
        <?php foreach ($_SESSION['MESSAGE_ERROR'] as $error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
        <?php unset($_SESSION['MESSAGE_ERROR']); // Nettoie les erreurs après affichage 
        ?>
    <?php endif; ?>
    <h1 class="text-center mt-5">Ajouter un commentaire</h1>
    <form action="comment_post_create.php" method="post">
        <?php if (isset($_SESSION['LOGGED_USER']['user_id'])): ?>
            <input type="id" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['LOGGED_USER']['user_id']; ?>" hidden>
        <?php endif; ?>
        <div class="mb-3">
            <input class="form-control" placeholder="Titre" id="recipe_id" name="recipe_id" value="<?php echo $_GET['id']; ?>" hidden></input>
        </div>
        <div class="mb-3">
            <label for="recette" class="form-label">Votre commentaire</label>
            <textarea class="form-control" id="comment" name="comment"></textarea>
        </div>
        <div class="mb-3">
            <label for="review">Note</label>
                <select class="form-select" aria-label="Default select example" name="review" >
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    </select>
            </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

<?php endif ?>