<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Enter your new Password</p>

    <?php include_once __DIR__ . '/../templates/alerts.php';?>

    <?php if($valid_token) { ?>
        <form method="POST" class="form">
            <div class="form__field">
                <label for="password" class="form__label">Password</label>
                <input
                    type="password"
                    class="form__input"
                    placeholder="Your Password"
                    id="password"
                    name="password"
                />
            </div>

            <input type="submit" class="form__submit" value="Save new Password"/>
        </form>
    <?php } ?>
    <div class="actions">
        <a href="/login" class="actions__link">Do you already have an account? Log in</a>
        <a href="/signup" class="actions__link">Don't have an account yet? Get one</a>
    </div>
</main>