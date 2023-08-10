<main class="diary">
    <h2 class="diary__heading"><?php echo $tittle; ?></h2>
    <p class="diary__description">Workshops and Conferences given by experts in Web Development</p>

    <div class="events">
        <h3 class="events__heading">&lt;Conferences /></h3>
        <p class="events__date">Friday November 24</p>

        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($events['f_conferences'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

        <p class="events__date">Saturday November 25</p>

        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($events['s_conferences'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>
    </div>

    <div class="events events--workshops">
        <h3 class="events__heading">&lt;Workshops /></h3>
        <p class="events__date">Friday November 24</p>

        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($events['f_workshops'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

        <p class="events__date">Saturday November 25</p>

        <div class="events__list slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($events['s_workshops'] as $event) { ?>
                    <?php include __DIR__ . '../../templates/event.php'; ?>
                <?php } ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>
    </div>
</main>