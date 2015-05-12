<?php 
/**
 * Include header.
 *
 */
echo $header; ?>

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
        	Account: <?php echo $omise['account']['email']; ?><br/>
        	Live Mode: <?php echo $omise['balance']['livemode'] ? 'Yes' : 'No'; ?><br/>
        	Currency: <?php echo $omise['balance']['currency']; ?><br/>
        	Available: <?php echo $omise['balance']['available']; ?><br/>
        	Total: <?php echo $omise['balance']['total']; ?><br/>
        </div>
    </div>
</div>

<?php
/**
 * Include footer.
 *
 */
 echo $footer; ?>