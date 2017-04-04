<!-- Include Omise's stylesheet -->
<link rel="stylesheet" type="text/css" href="catalog/view/stylesheet/omise/omise.css">

<!-- Include Omise's javascript -->
<script type="text/javascript">
    $("#omise-form-checkout").submit(function() {
        var form            = $(this),
            alertSuccess    = form.find(".alert-success"),
            alertError      = form.find(".alert-error"),
            overlay         = form.find('.overlay');

        // Show loading overlay.
        overlay.addClass('show');

        // Disable the submit button to avoid repeated click.
        form.find("input[type=submit]").prop("disabled", true);

        // Hidden alert box
        alertError.removeClass('show');
        alertSuccess.removeClass('show');

        // Charge with internet banking.
        var posting = $.post("<?php echo $checkout_url; ?>", {
            "offsite_provider": form.find("[data-omise=offsite_provider]:checked").val(),
            "description": "Charge an internet banking from OpenCart that order id is <?php echo $orderid; ?> from <?php echo $billemail; ?>"
        });

        posting
            .done(function(resp) {
                overlay.removeClass('show');
                resp = JSON.parse(resp);

                if (typeof resp.error !== "undefined") {
                    alertError.html("Omise Response: "+resp.error).addClass('show');
                } else if (resp.failure_code != null) {
                    alertError.html("Bank Response: "+resp.failure_message).addClass('show');
                } else if (typeof resp.redirect !== "undefined") {
                    console.log('redirect');
                    window.location = resp.redirect;
                } else {
                    alertSuccess.html("Succeed").addClass('show');
                    form.get(0).submit();
                }

                form.find("input[type=submit]").prop("disabled", false);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                overlay.removeClass('show');
                alertError.html("Omise "+errorThrown).addClass('show');
                form.find("input[type=submit]").prop("disabled", false);
            });

        // Prevent the form from being submitted;
        return false;
    });
</script>
<form id="omise-form-checkout" method="post" action="<?php echo $success_url; ?>">
    <img src="catalog/view/theme/default/image/secured_by_omise.png" width="200">
    <!-- Collect a customer's card -->
    <div class="omise-payment offsite">
        <h3>Internet Banking</h3>

        <!-- Alert box -->
        <div class="alert-box alert-error warning"></div>
        <div class="alert-box alert-success success"></div>

        <!-- Internet Banking providers -->
        <label class="input-group clearfix">
            <div class="left"><input type="radio" data-omise="offsite_provider" id="omise_offsite_scb" name="offsite_provider" value="internet_banking_scb" /></div>
            <div class="right">
                <div class="omise-logo-wrapper scb">
                    <img src="catalog/view/theme/default/image/omise-offsite-scb.svg" class="scb" />
                </div>
                <div class="omise-banking-text-wrapper">
                    <span class="title">Siam Commercial Bank</span><br/>
                    <span class="rate secondary-text">Fee: 15 THB (same zone), 30 THB (out zone)</span>
                </div>
            </div>
        </label>

        <label class="input-group clearfix">
            <div class="left"><input type="radio" data-omise="offsite_provider" id="omise_offsite_ktb" name="offsite_provider" value="internet_banking_ktb" /></div>
            <div class="right">
                <div class="omise-logo-wrapper ktb">
                    <img src="catalog/view/theme/default/image/omise-offsite-ktb.svg" class="ktb" />
                </div>
                <div class="omise-banking-text-wrapper">
                    <span class="title">Krungthai Bank</span><br/>
                    <span class="rate secondary-text">Fee: 15 THB (same zone), 15 THB (out zone)</span>
                </div>
            </div>
        </label>

        <label class="input-group clearfix">
            <div class="left"><input type="radio" data-omise="offsite_provider" id="omise_offsite_bay" name="offsite_provider" value="internet_banking_bay" /></div>
            <div class="right">
                <div class="omise-logo-wrapper bay">
                    <img src="catalog/view/theme/default/image/omise-offsite-bay.svg" class="bay" />
                </div>
                <div class="omise-banking-text-wrapper">
                    <span class="title">Krungsri Bank</span><br/>
                    <span class="rate secondary-text">Fee: 15 THB (same zone), 15 THB (out zone)</span>
                </div>
            </div>
        </label>

        <label class="input-group clearfix">
            <div class="left"><input type="radio" data-omise="offsite_provider" id="omise_offsite_bbl" name="offsite_provider" value="internet_banking_bbl" /></div>
            <div class="right">
                <div class="omise-logo-wrapper bbl">
                    <img src="catalog/view/theme/default/image/omise-offsite-bbl.svg" class="bbl" />
                </div>
                <div class="omise-banking-text-wrapper">
                    <span class="title">Bangkok Bank</span><br/>
                    <span class="rate secondary-text">Fee: 15 THB (same zone), 20 THB (out zone)</span>
                </div>
            </div>
        </label>
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