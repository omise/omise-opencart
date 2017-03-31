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

    <!-- Content -->
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><!--
                --><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div> <!-- /END .heading -->

        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <!-- Module config -->
                <h3>Mudule config</h3>
                <table class="form">
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td>
                            <select name="omise_offsite_status">
                                <option value="1" <?php echo $omise_offsite_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                                <option value="0" <?php echo !$omise_offsite_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>

            <div class="text-right" style="margin-top: 40px;">
                <a href="<?php echo $cancel; ?>" class="button">Back</a>
            </div>
        </div> <!-- /END .content -->
    </div> <!-- /END .box -->
</div>

<?php
/**
 * Include footer.
 *
 */
 echo $footer; ?>