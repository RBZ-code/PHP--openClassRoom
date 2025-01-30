<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <div class="container">
        <form action="submit_login.php" method="post">
            <?php if (isset($_SESSION['MESSAGE_ERROR'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <p><?php echo "{$_SESSION['MESSAGE_ERROR']}" ?></p>
                </div>
            <?php endif ?>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php endif ?>

<?php if (isset($_SESSION['LOGGED_USER'])) : ?>
    <?php if (!empty($_SESSION['MESSAGE_SUCCESS'])): ?>
        <div class="alert alert-success" role="alert">
            <p class="mb-0"><?php echo "{$_SESSION['MESSAGE_SUCCESS']}" ?></p>
        </div>
        <?php unset($_SESSION['MESSAGE_SUCCESS']); // Nettoie les erreurs après affichage 
        ?>
    <?php endif; ?>
<?php endif ?>