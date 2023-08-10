<header class="header">
    <div class="header__container">
        <nav class="header__navigation">

            <?php if(is_auth()) { ?> 
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/finish-registration'; ?>" class="header__link">Administer</a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Logout" class="header__submit"/>
                </form>
            <?php } else { ?>
                <a href="/signup" class="header__link">Sing Up</a>
                <a href="/login" class="header__link">Log In</a>
            <?php } ?>
        </nav>

        <div class="header__content">
            <a href="/">
                <h1 class="header__logo">
                    &#60;DevWebCamp />
                </h1>
            </a>

            <p class="header__text">November 24-25 - 2023</p>
            <p class="header__text header__text--modality">Online / In-Person</p>

            <a href="/signup" class="header__button">Buy Pass</a>

        </div>
    </div>
</header>

<div class="bar">
    <div class="bar__content">
        <a href="/">
            <h2 class="bar__logo" >&#60;DevWebCamp /></h2>
        </a>

        <nav class="navigation">
            <a href="/devwebcamp" class="navigation__link <?php echo current_page('/devwebcamp') ? 'navigation__link--current' : '' ?>">Event</a>
            <a href="/packages" class="navigation__link <?php echo current_page('/packages') ? 'navigation__link--current' : '' ?>">Packages</a>
            <a href="/workshops-conferences" class="navigation__link <?php echo current_page('/workshops-conferences') ? 'navigation__link--current' : '' ?>">Workshops / Conferences</a>
            <a href="/signup" class="navigation__link <?php echo current_page('/signup') ? 'navigation__link--current' : '' ?>">Buy Pass</a>
        </nav>
    </div>
</div>