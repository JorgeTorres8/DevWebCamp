<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Recover your access to DevWebCamp</p>

    <?php include_once __DIR__ . '/../templates/alerts.php';?>

    <form method="POST" action="/forgot" class="form">
        <div class="form__field">
            <label for="email" class="form__label">Email</label>
            <input
                type="email"
                class="form__input"
                placeholder="Your Email"
                id="email"
                name="email"
            />
        </div>

        <input type="submit" class="form__submit" value="Send Instructions"/>
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">Do you already have an account? Log in</a>
        <a href="/signup" class="actions__link">Don't have an account yet? Get one</a>
    </div>
</main>