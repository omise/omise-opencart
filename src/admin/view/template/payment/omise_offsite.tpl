<?php
/**
 * Include header.
 *
 */
echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" onclick="$('#form-setting').submit();" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>

      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div> <!-- /END .page-header -->

  <div class="container-fluid">
    <?php if ($error_warning) { ?>
      <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i>
        <?php if (is_array($error_warning)) {
          foreach ($error_warning as $key => $value) { echo $value; }
        } else {
          echo $error_warning;
        } ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>
    <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>

    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $label_setting_module_config; ?></h3>
        </div>

        <div class="panel-body">
          <!-- Module status -->
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="omise_offsite_status"><?php echo $label_setting_module_status; ?></label>
            <div class="col-sm-10">
              <select name="omise_offsite_status" class="form-control">
                <option value="1" <?php echo $omise_offsite_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0" <?php echo !$omise_offsite_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div> <!-- /END Module status (.form-group) -->

          <!-- Payment method title -->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="omise_offsite_payment_title"><?php echo $label_omise_offsite_payment_title; ?></label>
            <div class="col-sm-10">
              <input type="text" name="omise_offsite_payment_title" value="<?php echo $omise_offsite_payment_title; ?>" id="omise_offsite_payment_title" class="form-control" />
            </div>
          </div> <!-- /END Payment method title -->
        </div> <!-- /END .panel-body -->
      </div> <!-- /END .panel.panel-default -->
    </form>
  </div> <!-- /END .container-fluid -->
</div> <!-- /END #content -->

<!-- Include Omise's stylesheet -->
<link rel="stylesheet" type="text/css" href="view/stylesheet/omise.css">

<?php echo $footer; ?>
