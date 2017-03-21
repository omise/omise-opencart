<?php 
/**
 * Include header.
 *
 */
echo $header; ?>

<!-- Include Omise's stylesheet -->
<link rel="stylesheet" type="text/css" href="view/stylesheet/omise/omise-admin.css">

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

    <?php if ($omise): ?>
        <!-- Content -->
        <div class="box">
            <div class="heading">
                <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
                <div class="buttons">
                    <a href="<?php echo $setting_url; ?>" class="button"><?php echo $setting_button_title; ?></a>
                </div>
            </div> <!-- /END .heading -->

            <div class="content">

                <!-- Account Info -->
                <div class="omise-account-info omise-info-box">
                    <dl>
                        <!-- Account email -->
                        <dt>Account: </dt>
                        <dd><?php echo $omise['account']['email']; ?></dd>

                        <!-- Account status -->
                        <dt>Live Mode: </dt>
                        <dd><strong><?php echo $omise['balance']['livemode'] ? '<span class="livemode-label">Yes</span>' : '<span class="testmode-label">No</span>'; ?></strong></dd>

                        <!-- Current Currency -->
                        <dt>Currency: </dt>
                        <dd><?php echo strtoupper($omise['balance']['currency']); ?></dd>
                    </dl>
                </div>

                <!-- Balance -->
                <div class="omise-balance omise-clearfix">
                    <div class="left"><span class="omise-number"><?php echo formatDisplayPrice($omise['balance']['currency'], $omise['balance']['total']); ?></span><br/>Total Balance</div>
                    <div class="right"><span class="omise-number"><?php echo formatDisplayPrice($omise['balance']['currency'], $omise['balance']['available']); ?></span><br/>Transferable Balance</div>
                </div>

                <!-- Transfer History -->
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
                                    <td class="left"><?php echo formatDisplayPrice($omise['balance']['currency'], $value['amount']); ?></td>
                                    <td class="left"><?php echo $value['id']; ?></td>
                                    <td class="left"><?php echo $value['sent'] ? 'Yes' : 'No'; ?></td>
                                    <td class="left"><?php echo $value['paid'] ? 'Yes' : 'No'; ?></td>
                                    <td class="left"><?php echo $value['failure_code'] ? '('.$value['failure_code'].') '.$value['failure_code'] : '-'; ?></td>
                                    <td class="left" style="text-align: center;"><?php echo $date->format('M d, Y H:i'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="5" class="right"><input style="width: 20%" min="0" type="number" name="OmiseTransfer[amount]" placeholder="Transfer amount (number only)"></td>
                                <td style="text-align: center;"><button class="button btn-transfer">CREATE TRANSFER</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div> <!-- /END .content -->
        </div> <!-- /END .box -->
    <?php endif; ?>
</div>

<?php
/**
 * Include footer.
 *
 */
 echo $footer; ?>