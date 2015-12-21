<!-- Include Omise's javascript -->
<script type="text/javascript">
    $.getScript("https://cdn.omise.co/omise.min.js.gz", function() {
        Omise.setPublicKey("<?php echo $omise['pkey']; ?>");

        $("#omise-form-checkout").submit(function() {
            var form            = $(this),
                alertSuccess    = form.find(".alert-success"),
                alertError      = form.find(".alert-error"),
                overlay         = form.find('.overlay');

            // Show loading overlay.
            overlay.addClass('show');

            // Hidden alert box
            alertError.removeClass('show');
            alertSuccess.removeClass('show');

            // Disable the submit button to avoid repeated click.
            form.find("input[type=submit]").prop("disabled", true);

            // Serialize the form fields into a valid card object.
            var card = {
                "name": form.find("[data-omise=holder_name]").val(),
                "number": form.find("[data-omise=number]").val(),
                "expiration_month": form.find("[data-omise=expiration_month]").val(),
                "expiration_year": form.find("[data-omise=expiration_year]").val(),
                "security_code": form.find("[data-omise=security_code]").val()
            };

            // Send a request to create a token 
            // then trigger the callback function once a response is received from Omise.
            // * Note that the response could be an error and this needs to be handled
            // * within the callback.
            Omise.createToken("card", card, function (statusCode, response) {
                // If has an error (can not create a card's token).
                if (response.object == "error") {
                    // Display an error message.
                    alertError.html("Omise Response: "+response.message).addClass('show');

                    // Re-enable the submit button.
                    form.find("input[type=submit]").prop("disabled", false);
                } else if (typeof response.card != 'undefined' && !response.card.security_code_check) {
                    // Display an error message.
                    alertError.html("Omise Response: Card authorization failure.").addClass('show');

                    // Re-enable the submit button.
                    form.find("input[type=submit]").prop("disabled", false);
                } else {
                    // Token was created. Then, charge a card with token.
                    var posting = $.post("<?php echo $checkout_url; ?>", {
                        "omise_token": response.id,
                        "description": "Charge a card from OpenCart that order id is <?php echo $orderid; ?> from <?php echo $billemail; ?>"
                    });

                    posting
                        .done(function(resp) {
                            resp = JSON.parse(resp);

                            if (typeof resp.error != "undefined") {
                                alertError.html("Omise Response: "+resp.error).addClass('show');
                                form.find("input[type=submit]").prop("disabled", false);
                            } else if (resp.failure_code != null) {
                                alertError.html("Bank Response: "+resp.failure_message).addClass('show');
                                form.find("input[type=submit]").prop("disabled", false);
                            } else {
                                alertSuccess.html("Succeed").addClass('show');
                                form.get(0).submit();
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            alertError.html("Omise "+errorThrown).addClass('show');
                        });
                };

                overlay.removeClass('show');
            });

            // Prevent the form from being submitted;
            return false;
        });
    });
</script>

<!-- Omise's checkout form -->
<form id="omise-form-checkout" method="post" action="<?php echo $success_url; ?>">
    <!-- Collect a customer's card -->
    <div class="omise-payment">
        <h3>Card Information</h3>
        
        <!-- Alert box -->
        <div class="alert-box alert-error warning"></div>
        <div class="alert-box alert-success success"></div>

        <!-- Token -->
        <input type="hidden" name="omise_token" class="input-omise-token">

        <!-- Card Holder Name -->
        <div class="input-group clearfix">
            <div class="left"><label>Card Holder Name</label></div>
            <div class="right">
                <input type="text" data-omise="holder_name" value="" class="input-omise-collect-holder-name">
            </div>
        </div>
        
        <!-- Card Number -->
        <div class="input-group clearfix">
            <div class="left"><label>Card Number</label></div>
            <div class="right">
                <input type="text" data-omise="number" value="" class="input-omise-collect-number">
            </div>
        </div>
        
        <!-- Expiration date -->
        <div class="input-group clearfix">
            <div class="left"><label>Expire Date</label></div>
            <div class="right">
                <select data-omise="expiration_month" class="input-omise-collect-expiration-month"> >
                <?php foreach ($loop_months as $k=>$v): ?>
                    <option value="<?php echo $k?$k:'' ?>"><?php echo $v ?></option>
                <?php endforeach ?>
                </select>
                <select data-omise="expiration_year" class="input-omise-collect-expiration-year">
                <?php foreach ($loop_years as $k=>$v): ?>
                    <option value="<?php echo $k?$k:'' ?>"><?php echo $v ?></option>
                <?php endforeach ?>
                </select>
            </div>
        </div>
        
        <!-- Security Code -->
        <div class="input-group clearfix">
            <div class="left"><label>Security Code</label></div>
            <div class="right">
                <input type="password" data-omise="security_code" size="8" value="" class="input-omise-collect-security-code">
            </div>
        </div>
    </div>

    <!-- Button -->
    <div class="buttons">
        <div class="right">
            <input type="submit" value="<?php echo $button_confirm; ?>" class="button btn-checkout" />
        </div>
    </div>

    <!-- OpenCart's hidden input -->
    <input type="hidden" name="text_config_one" value="<?php echo $text_config_one; ?>" />
    <input type="hidden" name="text_config_two" value="<?php echo $text_config_two; ?>" />
    <input type="hidden" name="orderid" value="<?php echo $orderid; ?>" />
    <input type="hidden" name="callbackurl" value="<?php echo $callbackurl; ?>" />
    <input type="hidden" name="orderdate" value="<?php echo $orderdate; ?>" />
    <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
    <input type="hidden" name="orderamount" value="<?php echo $orderamount; ?>" />
    <input type="hidden" name="billemail" value="<?php echo $billemail; ?>" />
    <input type="hidden" name="billphone" value="<?php echo $billphone; ?>" />
    <input type="hidden" name="billaddress" value="<?php echo $billaddress; ?>" />
    <input type="hidden" name="billcountry" value="<?php echo $billcountry; ?>" />
    <input type="hidden" name="billprovince" value="<?php echo $billprovince; ?>" />
    <input type="hidden" name="billcity" value="<?php echo $billcity; ?>" />
    <input type="hidden" name="billpost" value="<?php echo $billpost; ?>" />
    <input type="hidden" name="deliveryname" value="<?php echo $deliveryname; ?>" />
    <input type="hidden" name="deliveryaddress" value="<?php echo $deliveryaddress; ?>" />
    <input type="hidden" name="deliverycity" value="<?php echo $deliverycity; ?>" />
    <input type="hidden" name="deliverycountry" value="<?php echo $deliverycountry; ?>" />
    <input type="hidden" name="deliveryprovince" value="<?php echo $deliveryprovince; ?>" />
    <input type="hidden" name="deliveryemail" value="<?php echo $deliveryemail; ?>" />
    <input type="hidden" name="deliveryphone" value="<?php echo $deliveryphone; ?>" />
    <input type="hidden" name="deliverypost" value="<?php echo $deliverypost; ?>" />

    <!-- Overlay -->
    <div class="overlay"></div>
</form>