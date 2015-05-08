<?php 
/**
 * Include header.
 *
 */
echo $header; ?>

<!-- Local Stylesheet -->
<style type="text/css">
    #form h3                        { margin: 30px 0 10px; }
    #form h3:first-child            { margin-top: 10px; }

    table.form                      { background: #fafafa; }
    table.form > tbody > tr > td    { border-bottom: none; }
    table.form input                { width: 25%; }

    .text-right                     { text-align: right; }
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
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><!--
                --><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
            </div>
        </div> <!-- /END .heading -->

        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

                <!-- Omise Test Key config -->
                <h3>Test Keys</h3>
                <table class="form">

                    <!-- o_public_key_test -->
                    <tr>
                        <td><?php echo $omise_key_test_public_label; ?></td>
                        <td>
                            <input type="password" name="Omise[public_key_test]" value="<?php echo $public_key_test; ?>" />
                            <?php if (isset($input_error['public_key_test'])) echo '<span class="error">'.$input_error['public_key_test'].'</span>'; ?>
                        </td>
                    </tr>

                    <!-- o_secret_key_test -->
                    <tr>
                        <td><?php echo $omise_key_test_secret_label; ?></td>
                        <td>
                            <input type="password" name="Omise[secret_key_test]" value="<?php echo $secret_key_test; ?>" />
                            <?php if (isset($input_error['secret_key_test'])) echo '<span class="error">'.$input_error['secret_key_test'].'</span>'; ?>
                        </td>
                    </tr>

                    <!-- o_test_mode -->
                    <tr>
                        <td><?php echo $omise_test_mode_label; ?></td>
                        <td>
                            <input type="checkbox" name="Omise[test_mode]" value="1" <?php echo $test_mode ? 'checked' : ''; ?> />
                            <?php if (isset($input_error['test_mode'])) echo '<span class="error">'.$input_error['test_mode'].'</span>'; ?>
                        </td>
                    </tr>
                </table>

                <!-- Omise Live Key config -->
                <h3>Live Keys</h3>
                <table class="form">

                    <!-- o_public_key -->
                    <tr>
                        <td><span class="required">*</span> <?php echo $omise_key_public_label; ?></td>
                        <td>
                            <input type="password" name="Omise[public_key]" value="<?php echo $public_key; ?>" />
                            <?php if (isset($input_error['public_key'])) echo '<span class="error">'.$input_error['public_key'].'</span>'; ?>
                        </td>
                    </tr>

                    <!-- o_secret_key -->
                    <tr>
                        <td><span class="required">*</span> <?php echo $omise_key_secret_label; ?></td>
                        <td>
                            <input type="password" name="Omise[secret_key]" value="<?php echo $secret_key; ?>" />
                            <?php if (isset($input_error['secret_key'])) echo '<span class="error">'.$input_error['secret_key'].'</span>'; ?>
                        </td>
                    </tr>
                </table>

                <!-- Module config -->
                <h3>Mudule config</h3>
                <table class="form">
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td>
                            <select name="omise_status">
                                <option value="1" <?php echo $omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                                <option value="0" <?php echo !$omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
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