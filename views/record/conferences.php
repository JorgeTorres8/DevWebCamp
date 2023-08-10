
<h2 class="page__heading"><?php echo $tittle; ?></h2>
<p class="page__description">Choose up to 5 events to attend in person.</p>

<div class="events-record">
    <main class="events-record__list">
        <h3 class="events-record__heading--conferences">&lt;Conferences /></h3>
        <p class="events-record__date">Friday November 24</p>

        <div class="events-record__grid">
            <?php foreach($events['f_conferences'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-record__date">Saturday November 25</p>

        <div class="events-record__grid">
            <?php foreach($events['s_conferences'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <h3 class="events-record__heading--workshops">&lt;Workshops /></h3>
        <p class="events-record__date">Friday November 24</p>

        <div class="events-record__grid events--workshops">
            <?php foreach($events['f_workshops'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-record__date">Saturday November 25</p>

        <div class="events-record__grid events--workshops">
            <?php foreach($events['s_workshops'] as $event) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

    </main>

    <aside class="record">
        <h2 class="record__heading">Your Records</h2>

        <div id="record-summary" class="record__summary"></div>

        <div class="record__gift">
            <label for="gift" class="record__label">Select a Present</label>
            <select id="gift" class="record__select">
                <option value="">-- Select your Gift --</option>
                <?php foreach($gifts as $gift) { ?>
                    <option value="<?php echo $gift->id;?>"><?php echo $gift->name;?></option>
                <?php } ?>
            </select>
        </div>
        
        <form id="record" class="form">
            <div class="form__field">
                <input type="submit" class="form__submit form__submit--full" value="Register"/>
            </div>
        </form>
    </aside>
</div>