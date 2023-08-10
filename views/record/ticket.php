<min class="page">
    <h2 class="page__heading"><?php echo $tittle; ?></h2>
    <p class="page__description">Your Ticket - We recommend you store it, you can share it on social networks</p>

    <div class="ticket-virtual">
        <div class="ticket ticket--<?php echo strtolower($registration->package->name); ?> ticket--access">
            <div class="ticket__content">
                <h4 class="ticket__logo">&#60;DevWebCamp /></h4>
                <p class="ticket__plan"><?php echo $registration->package->name; ?></p>
                <p class="ticket__name"><?php echo $registration->user->name . " " . $registration->user->lastname; ?></p>
            </div>

            <p class="ticket__code"><?php echo '#' . $registration->token; ?></p>
        </div>
    </div>
</min>