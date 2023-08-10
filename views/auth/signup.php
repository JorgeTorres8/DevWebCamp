<main class="auth">
    <h2 class="auth__heading"><?php echo $tittle; ?></h2>
    <p class="auth__text">Sing Up for DevWebCamp</p>

    <?php require_once __DIR__ . '/../templates/alerts.php'?>

    <form method="POST" action="/signup" class="form">

        <div class="form__field">
            <label for="name" class="form__label">Name</label>
            <input
                type="name"
                class="form__input"
                placeholder="Your Name"
                id="name"
                name="name"
                value="<?php echo $user->name; ?>"
            />
        </div>

        <div class="form__field">
            <label for="lastname" class="form__label">Lastname</label>
            <input
                type="lastname"
                class="form__input"
                placeholder="Your Lastname"
                id="lastname"
                name="lastname"
                value="<?php echo $user->lastname; ?>"
            />
        </div>


        <div class="form__field">
            <label for="email" class="form__label">Email</label>
            <input
                type="email"
                class="form__input"
                placeholder="Your Email"
                id="email"
                name="email"
                value="<?php echo $user->email; ?>"
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
                value="<?php echo $user->password; ?>"
            />
        </div>

        <div class="form__field">
            <label for="password2" class="form__label">Repeat Password</label>
            <input
                type="password"
                class="form__input"
                placeholder="Repeat Your Password"
                id="password2"
                name="password2"
                value="<?php echo $user->password2; ?>"
            />
        </div>

        <input type="submit" class="form__submit" value="Create Account"/>
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">Do you already have an account? Log in</a>
        <a href="/forgot" class="actions__link">Did you forget your password?</a>
    </div>
</main>