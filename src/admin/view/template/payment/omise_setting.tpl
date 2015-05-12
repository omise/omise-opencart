<?php 
/**
 * Include header.
 *
 */
echo $header; ?>

<!-- Local Stylesheet -->
<style type="text/css">
    #form h3                                { margin: 30px 0 10px; }
    #form h3:first-child                    { margin-top: 10px; }

    table.form                              { background: #fafafa; }
    table.form > tbody > tr > td            { border-bottom: none; }
    table.form input                        { width: 25%; }

    .text-right                             { text-align: right; }

    .omise-admin-menu-section               { margin-top: 50px; }
    .omise-admin-menu-btn-install           { background: #8DA038; color: #fff; border: 0; cursor: pointer; border-radius: 2px; padding: 8px 20px; font-size: 14px; }
    .omise-admin-menu-btn-install:hover     { background: #809133; }

    .omise-admin-menu-section .description  { margin-top: 10px; text-shadow: 1px 1px #fff; color: #666; background: #f5f5f5; padding: 10px; }
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

            <section class="omise-admin-menu-section">
                <h2>Install Omise's admin menu</h2>
                <p>Install Omise menu in admin menu bar on the top of admin page.</p>

                <div class="alert-box"></div>

                <button data-installvqmod-link="<?php echo $install_vqmod; ?>" class="omise-admin-menu-btn-install">Install now</button>

                <div class="description">
                    <p>If you click the <strong>Install now</strong> button, it will installing <a href="https://github.com/vqmod/vqmod" target="_blank">vQmod library</a> into your OpenCart. The steps as follows</p>
                    <ul>
                        <li>Edit you <strong>index.php</strong> file</li>
                        <li>Edit you <strong>admin/index.php</strong> file</li>
                    </ul>
                </div>

            </section>
            <div class="text-right" style="margin-top: 40px;">
                <a href="<?php echo $cancel; ?>" class="button">Back</a>
            </div>
        </div> <!-- /END .content -->
    </div> <!-- /END .box -->
</div>

<script>
    $(document).ready(function(){
        $('.omise-admin-menu-btn-install').on('click', function(e) {
            e.preventDefault();

            var url             = $(this).attr('data-installvqmod-link'),
                alertSection    = $(".alert-box");

            var posting = $.post(url);

            alertSection.empty();
            posting.done(function(resp) {
                resp = JSON.parse(resp);

                if (typeof resp.error != "undefined") {
                    alertSection.html("<div class='warning'>"+resp.error+"</div>");
                } else {
                    alertSection.html("<div class='success'>"+resp.msg+"</div>");
                }
            });
        });
    });
</script>

<?php
/**
 * Include footer.
 *
 */
 echo $footer; ?>