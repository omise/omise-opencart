<?php 
/**
 * Include header.
 *
 */
echo $header; ?><?php echo $column_left; ?>

<!-- Include Omise's stylesheet -->

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" onclick="$('#form').submit();" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($success) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
        <?php if ($error) echo '<div class="alert alert-warning">'.$error.'</div>'; ?>
        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> Module Config</h3>
                </div>
                <div class="panel-body">

                    <!-- o_test_mode -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_test_modet"><?php echo $omise_test_mode_label; ?></label>
                      <div class="col-sm-10">
                            <select name="omise_status" class="form-control">
                                <option value="1" <?php echo $omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                                <option value="0" <?php echo !$omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
                            </select>
                      </div>
                    </div>
                </div>
            </div>

            <!-- test mode -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> Test Keys</h3>
                </div>
                <div class="panel-body">
                    <!-- o_public_key_test -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_public_key_test"><?php echo $omise_key_test_public_label; ?></label>
                      <div class="col-sm-10">
                        <input size="40" type="password" name="omise_public_key_test" value="<?php echo $public_key_test; ?>" id="omise_payments_public_key_test" class="form-control" />
                      </div>
                    </div>

                    <!-- o_secret_key_test -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_secret_key_test"><?php echo $omise_key_test_secret_label; ?></label>
                      <div class="col-sm-10">
                        <input size="40" type="password" name="omise_secret_key_test" value="<?php echo $secret_key_test; ?>" id="omise_payments_secret_key_test" class="form-control" />
                      </div>
                    </div>

                    <!-- o_test_mode -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_test_modet"><?php echo $omise_test_mode_label; ?></label>
                      <div class="col-sm-10">
                        <input type="checkbox" name="omise_test_mode" value="1" <?php echo $test_mode ? 'checked' : ''; ?> class="form-control" />
                      </div>
                    </div>        
                </div>
            </div>

            <!-- live mode -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> Live Keys</h3>
                </div>
                <div class="panel-body">
                    <!-- o_public_key -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_public_key"><?php echo $omise_key_public_label; ?></label>
                      <div class="col-sm-10">
                        <input size="40" type="password" name="omise_public_key" value="<?php echo $public_key; ?>" id="omise_payments_public_key" class="form-control" />
                      </div>
                    </div>

                    <!-- o_secret_key -->
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="omise_payments_secret_key"><?php echo $omise_key_secret_label; ?></label>
                      <div class="col-sm-10">
                        <input size="40" type="password" name="omise_secret_key" value="<?php echo $secret_key; ?>" id="omise_payments_secret_key" class="form-control" />
                      </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $footer; ?>
