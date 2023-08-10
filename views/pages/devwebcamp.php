<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $tittle; ?></h2>
    <p class="devwebcamp__description">Meet the most important conference for developers</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animation(); ?> class="devwebcamp__image">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebCamp">
            </picture>
        </div>

        <div class="devwebcamp__content">
            <p <?php aos_animation(); ?> class="devwebcamp__text"> Suspendisse ullamcorper consequat dictum. Morbi id tristique nunc. 
                Nunc mollis nisl sit amet lacus dictum, in interdum ipsum pretium.
                Nulla nec elit mattis, consectetur arcu ac, viverra enim. Suspendisse et leo vulputate, accumsan lectus sed, malesuada nulla. 
                Integer ac velit vitae lacus luctus viverra tincidunt ut massa.
            </p>
            
            <p <?php aos_animation(); ?> class="devwebcamp__text"> Suspendisse ullamcorper consequat dictum. Morbi id tristique nunc. 
                Nunc mollis nisl sit amet lacus dictum, in interdum ipsum pretium.
                Nulla nec elit mattis, consectetur arcu ac, viverra enim. Suspendisse et leo vulputate, accumsan lectus sed, malesuada nulla. 
                Integer ac velit vitae lacus luctus viverra tincidunt ut massa. Nunc vel eleifend elit, sit amet lacinia mauris.
            </p>
        </div>

    </div>
</main>