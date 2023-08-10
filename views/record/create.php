<main class="record">
    <h2 class="record__heading"><?php echo $tittle; ?></h2>
    <p class="record__description">Choose your plan</p>

    <div class="packages__grid">
        <div class="package">
            <h3 class="package__name">Free Pass</h3>
            <ul class="package__list">
                <li class="package__element">Virtual Access to DevWebCamp</li>
            </ul>

            <p class="package__price">$0</p>

            <form method="POST" action="/finish-registration/free"> 
                <input class="packages__submit" type="submit" value="Free Registration"/>
            </form>
        </div>

        <div <?php aos_animation(); ?> class="package">
            <h3 class="package__name">In-person Pass</h3>
            <ul class="package__list">
                <li class="package__element">In-person Access to DevWebCamp</li>
                <li class="package__element">Pass for 2 days</li>
                <li class="package__element">Access to Workshops and Conferences</li>
                <li class="package__element">Access to Recordings</li>
                <li class="package__element">Event Shirt</li>
                <li class="package__element">Food and Drink</li>
            </ul>

            <p class="package__price">$199</p>

            <div id="smart-button-container"> 
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="package">
            <h3 class="package__name">Virtual Pass</h3>
            <ul class="package__list">
                <li class="package__element">Virtual Access to DevWebCamp</li>
                <li class="package__element">Pass for 2 days</li>
                <li class="package__element">Access to Workshops and Conferences</li>
                <li class="package__element">Access to Recordings</li>
            </ul>

            <p class="package__price">$49</p>

            <div id="smart-button-container"> 
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=AcCXNgLTIkkYAU5WwHC3jeC-YlQSzPIeCFbFUMUG-RMyNY0x51wCOjBo0O5lubbv6raxHmnz4o_uO6Hc&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>

<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) { 
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}] 
          });
        },
 
        onApprove: function(data, actions) { 
          return actions.order.capture().then(function(orderData) {
 
          const data = new FormData();
          data.append('package_id', orderData.purchase_units[0].description);
          data.append('pay_id', orderData.purchase_units[0].payments.captures[0].id);

          fetch('/finish-registration/pay', {
            method: 'POST',
            body: data
          })
          .then(response => response.json())
          .then(result => {
            if(result.result) {
                actions.redirect('/finish-registration/conferences')
            }
          })
            
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
 
    // Virtual Pass
    paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) { 
          return actions.order.create({
            purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":49}}]
          });
        },
 
        onApprove: function(data, actions) { 
          return actions.order.capture().then(function(orderData) {
 
          const data = new FormData();
          data.append('package_id', orderData.purchase_units[0].description);
          data.append('pay_id', orderData.purchase_units[0].payments.captures[0].id);

          fetch('/finish-registration/pay', {
            method: 'POST',
            body: data
          })
          .then(response => response.json())
          .then(result => {
            if(result.result) {
                actions.redirect('/finish-registration/conferences')
            }
          })
          /*  // Full available details 
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
 
            // Show a success message within this page, e.g.
            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '';
            element.innerHTML = '<h3>Thank you for your payment!</h3>';
 
            // Or go to another URL:  actions.redirect('thank_you.html');*/
            
          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container-virtual');
  initPayPalButton();
</script>
