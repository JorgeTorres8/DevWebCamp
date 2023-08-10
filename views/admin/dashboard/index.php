<h2 class="dashboard__heading"><?php echo $tittle; ?></h2>

<main class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__heading">Last Records</h3>
            <?php foreach($records as $record) { ?>
                <div class="block__content">
                    <p class="block__text"><?php echo $record->user->name . " " . $record->user->lastname; ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Revenue</h3>
            <p class="block__text--amount">$ <?php echo $revenue ?></p>
        </div>

        <div class="block">
            <h3 class="block__heading">Events with fewer places available</h3>
            <?php foreach($fewer_available as $event) { ?>
                <div class="block__content">
                    <p class="block__text"><?php echo $event->name . " - " . $event->available . ' Available'; ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Events with more places available</h3>
            <?php foreach($more_available as $event) { ?>
                <div class="block__content">
                    <p class="block__text"><?php echo $event->name . " - " . $event->available . ' Available'; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</main>