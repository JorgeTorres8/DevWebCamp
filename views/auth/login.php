<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Log in to DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alerts.php' ?>

    <form method="POST" action="/login" class="form">
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


        <div class="form__field">
            <label for="password" class="form__label">Password</label>
            <input
                type="password"
                class="form__input"
                placeholder="Your password"
                id="password"
                name="password"
            />
        </div>

        <input type="submit" class="form__submit" value="Log In"/>
    </form>

    <div class="actions">
        <a href="/signup" class="actions__link">Don't have an account yet? Get one</a>
        <a href="/forgot" class="actions__link">Did you forget your password?</a>
    </div>
</main>