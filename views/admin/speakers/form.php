<fieldset class="form__fieldset">
    <legend class="form__legend">Personal Information</legend>

    <div class="form__field">
        <label for="name" class="form__label">Name</label>

        <input
            type="text"
            class="form__input"
            id="name"
            name="name"
            placeholder="Speaker Name"
            value="<?php echo $speaker->name ?? ''?>"

        />
    </div>

    <div class="form__field">
        <label for="lastname" class="form__label">Lastname</label>

        <input
            type="text"
            class="form__input"
            id="lastname"
            name="lastname"
            placeholder="Speaker Lastname"
            value="<?php echo $speaker->lastname ?? ''?>"
        />
    </div>

    <div class="form__field"> 
        <label for="city" class="form__label">City</label>

        <input
            type="text"
            class="form__input"
            id="city"
            name="city"
            placeholder="Speaker City"
            value="<?php echo $speaker->city ?? ''?>"
        />
    </div>

    <div class="form__field">
        <label for="country" class="form__label">Country</label>

        <input
            type="text"
            class="form__input"
            id="country"
            name="country"
            placeholder="Speaker Country"
            value="<?php echo $speaker->country ??''?>"
        />
    </div>

    <div class="form__field">
        <label for="image" class="form__label">Image</label>

        <input
            type="file"
            class="form__input form__input--file"
            id="image"
            name="image"
        />
    </div>

    <?php if(isset($speaker->current_image)) { ?> 
        <p class="form__text">Current Image:</p>
        <div class="form__image">

            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $speaker->image; ?>.png" alt="Speaker Image">
            </picture>
        </div>
    <?php } ?>
</fieldset>

<fieldset class="form__fieldset"> 
    <legend class="form__legend">Extra Information</legend>

    <div class="form__field">
        <label for="tags_input" class="form__label">Expertise Areas (separated by commas)</label>

        <input
            type="text"
            class="form__input"
            id="tags_input"
            placeholder="Eg. Node.js, PHP, CSS, Laravel, UX/UI"
        />
    </div>

    <div id="tags" class="form__list"></div>
    <input type="hidden" name="tags" value="<?php echo $speaker->tags ?? ''; ?>">

</fieldset>

<fieldset class="form__fieldset"> 
    <legend class="form__legend">Social Networks</legend>

    <div class="form__field">
        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-facebook"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[facebook]"
                placeholder="Facebook"
                value="<?php echo $networks->facebook ?? ''?>"
            />

        </div>

        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-twitter"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[twitter]"
                placeholder="Twitter"
                value="<?php echo $networks->twitter ?? ''?>"
            />
        </div>

        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[youtube]"
                placeholder="YouTube"
                value="<?php echo $networks->youtube ?? ''?>"
            />

        </div>

        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-instagram"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[instagram]"
                placeholder="Instagram"
                value="<?php echo $networks->instagram ?? ''?>"
            />
        </div>

        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-tiktok"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[tiktok]"
                placeholder="Tiktok"
                value="<?php echo $networks->tiktok ?? ''?>"
            />
        </div>
        
        <div class="form__container-icon">

            <div class="form__icon">
                <i class="fa-brands fa-github"></i>
            </div>

            <input
                type="text"
                class="form__input--social"
                name="networks[github]"
                placeholder="GitHub"
                value="<?php echo $networks->github ?? ''?>"
            />
        </div>

    </div>
</fieldset>