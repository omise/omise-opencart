<?php 
/**
 * Include header.
 *
 */
echo $header; ?>

<!-- Local Stylesheet -->
<style type="text/css">
    .omise-info-box                     { background: #f5f5f5; padding: 10px; color: #666; text-shadow: 1px 1px #fff; }
    .omise-info-box dl dt,
    .omise-info-box dl dd               { display: inline; }
    .omise-info-box dl dt               { display: inline; font-weight: 700; margin-left: 40px; }
    .omise-info-box dl dt:first-child   { margin-left: 0; }
    .omise-info-box dl dd               { margin-left: 10px; }

    .omise-account-info                 { font-size: 1.1em; border-bottom: 1px solid #5A5959; border-radius: 2px 2px 0 0; }

    .omise-balance                      { background: #2d2d2d; color: #D8D8D8; padding: 20px 0; border-top: 1px solid #E5E5E5; border-bottom: 2px solid #1d1d1d; }
    .omise-balance .left,
    .omise-balance .right               { float: left; width: 50%; text-align: center; }
    .omise-balance .omise-number        { font-size: 2.5em; color: #fff; }

    .omise-clearfix:before,
    .omise-clearfix:after               { display: table; content: " "; }
    .omise-clearfix:after               { clear: both; }

    button.button                       { cursor: pointer; border: 0; text-decoration: none; color: #FFF; display: inline-block; padding: 5px 15px 5px 15px; background: #003A88; -webkit-border-radius: 10px 10px 10px 10px; -moz-border-radius: 10px 10px 10px 10px; -khtml-border-radius: 10px 10px 10px 10px; border-radius: 10px 10px 10px 10px; }
</style>

<div id="content">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <?php
        foreach ($breadcrumbs as $breadcrumb):
            echo $breadcrumb['separator'];
            echo '<a href="'.$breadcrumb['href'].'">'.$breadcrumb['text'].'</a>';
        endforeach;
        ?>
    </div> <!-- /END .breadcrumb -->

    <!-- Session flash box -->
    <?php if ($success) echo '<div class="success">'.$success.'</div>'; ?>
    <?php if ($error) echo '<div class="warning">'.$error.'</div>'; ?>

    <!-- Content -->
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a href="<?php echo $back_url; ?>" class="button"><?php echo $back_button_title; ?></a>
            </div>
        </div> <!-- /END .heading -->

        <div class="content">
            <div class="omise-account-info omise-info-box">
                <dl>
                    <dt>Account: </dt>
                    <dd><?php echo $omise['account']['email']; ?></dd>

                    <dt>Live Mode: </dt>
                    <dd><?php echo $omise['balance']['livemode'] ? 'Yes' : 'No'; ?></dd>

                    <dt>Currency: </dt>
                    <dd><?php echo strtoupper($omise['balance']['currency']); ?></dd>
                </dl>
            </div>

            <div class="omise-balance omise-clearfix">
                <div class="left"><span class="omise-number"><?php echo number_format(($omise['balance']['total']/100), 2); ?></span><br/>Total Balance</div>
                <div class="right"><span class="omise-number"><?php echo number_format(($omise['balance']['available']/100), 2); ?></span><br/>Transferable Balance</div>
            </div>

            <div class="omise-transfer-history"><h3>Transfer History</h3></div>
            <form id="omise-transfer" method="post" action="<?php echo $transfer_url; ?>">
                <table class="list">
                    <thead>
                        <tr>
                            <td class="left">Amount</td>
                            <td class="left">Transfer Id</td>
                            <td class="left">Sent</td>
                            <td class="left">Paid</td>
                            <td class="left">Failure Message</td>
                            <td class="left" width="15%" style="text-align: center;">Created</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($omise['transfer']['data'] as $key => $value): $date = new \DateTime($value['created']); ?>
                            <tr>
                                <td class="left"><?php echo number_format(($value['amount']/100), 2); ?></td>
                                <td class="left"><?php echo $value['id']; ?></td>
                                <td class="left"><?php echo $value['sent'] ? 'Yes' : 'No'; ?></td>
                                <td class="left"><?php echo $value['paid'] ? 'Yes' : 'No'; ?></td>
                                <td class="left"><?php echo $value['failure_code'] ? '('.$value['failure_code'].') '.$value['failure_code'] : '-'; ?></td>
                                <td class="left" style="text-align: center;"><?php echo $date->format('M d, Y H:i'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" class="right"><input style="width: 20%" type="text" name="OmiseTransfer[amount]" placeholder="Transfer amount (number only)"></td>
                            <td style="text-align: center;"><button class="button btn-transfer">CREATE TRANSFER</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#omise-transfer").submit(function() {
            var form    = $(this);

            form.get(0).submit();
        });
    });
</script>

<?php
/**
 * Include footer.
 *
 */
 echo $footer; ?>