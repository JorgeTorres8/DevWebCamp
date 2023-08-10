<?php
    include_once __DIR__ . '/conferences.php';
?>

<section class="summary">
    <div class="summary__grid">
        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $total_speakers; ?></p>
            <p class="summary__text">Speakers</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $total_conferences ?></p>
            <p class="summary__text">Conferences</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $total_workshops ?></p>
            <p class="summary__text">Workshops</p>
        </div>

        <div <?php aos_animation(); ?> class="summary__block">
            <p class="summary__text summary__text--number">200</p>
            <p class="summary__text">Assistants</p>
        </div>
    </div>
</section>

<section class="sepakers">
    <h2 class="sepakers__heading">Speakers</h2>
    <p class="sepakers__description">Meet our experts from DevWebCamp</p>

    <div class="speakers__grid">
        <?php foreach($speakers as $speaker) { ?>
            <div <?php aos_animation(); ?> class="speaker">
                <picture>
                    <source srcset="img/speakers/<?php echo $speaker->image; ?>.webp" type="image/webp">
                    <source srcset="img/speakers/<?php echo $speaker->image; ?>.png" type="image/png">
                    <img class="speaker__image" loading="lazy" width="200" height="300" src="img/speakers/<?php echo $speaker->image; ?>.png" alt="Speaker Image">
                </picture>

                <div class="speaker__information">
                    <h4 class="speaker__name">
                        <?php echo $speaker->name . ' ' . $speaker->lastname; ?>
                    </h4>

                    <p class="speaker__location"><?php echo $speaker->city . ', ' . $speaker->country; ?></p>

                    <nav class="speaker-social">
                        <?php 
                            $networks = json_decode($speaker->networks);
                        ?>
                        
                        <?php if(!empty($networks->facebook)) { ?>
                            <a id="facebook" class="speaker-social__link" href="<?php echo $networks->facebook; ?>">
                                <span class="speaker-social__hide">Facebook</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($networks->twitter)) { ?>
                            <a id="twitter" class="speaker-social__link" href="<?php echo $networks->twitter; ?>">
                                <span class="speaker-social__hide">Twitter</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($networks->youtube)) { ?>
                            <a id="youtube" class="speaker-social__link" href="<?php echo $networks->youtube; ?>">
                                <span class="speaker-social__hide">YouTube</span>
                            </a>
                        <?php } ?>

                        <?php if(!empty($networks->instagram)) { ?>
                            <a id="instagram" class="speaker-social__link" href="<?php echo $networks->instagram; ?>">
                                <span class="speaker-social__hide">Instagram</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($networks->tiktok)) { ?>
                            <a id="tiktok" class="speaker-social__link" href="<?php echo $networks->tiktok; ?>">
                                <span class="speaker-social__hide">Tiktok</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($networks->github)) { ?>
                            <a id="github" class="speaker-social__link" href="<?php echo $networks->github; ?>">
                                <span class="speaker-social__hide">GitHub</span>
                            </a>
                        <?php } ?>
                    </nav>

                    <ul class="speaker__list-skills">
                        <?php
                            $tags = explode(',', $speaker->tags);
                            foreach($tags as $tag) { ?>
                                <li class="speaker__skill"><?php echo $tag; ?></li>    
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id=map class="map"></div>

<section class="tickets">
    <h2 class="tickets__heading">Tickets & Price</h2>
    <p class="tickets__description">Prices for DebWebCamp</p>

    <div class="tickets__grid">
        <div <?php aos_animation(); ?> class="ticket ticket--in-person">
            <h4 class="ticket__logo">&#60;DevWebCamp /></h4>
            <p class="ticket__plan">In Person</p>
            <p class="ticket__price">$199</p>
        </div>

        <div <?php aos_animation(); ?> class="ticket ticket--virtual">
            <h4 class="ticket__logo">&#60;DevWebCamp /></h4>
            <p class="ticket__plan">Virtual</p>
            <p class="ticket__price">$49</p>
        </div>

        <div <?php aos_animation(); ?> class="ticket ticket--free">
            <h4 class="ticket__logo">&#60;DevWebCamp /></h4>
            <p class="ticket__plan">Free</p>
            <p class="ticket__price">Free - 0</p>
        </div>
    </div>

    <div class="ticket__link--container">
        <a href="/packages" class="ticket__link">View Packages</a>
    </div>
</section>