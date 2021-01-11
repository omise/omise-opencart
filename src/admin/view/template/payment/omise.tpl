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

    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab-dashboard" data-toggle="tab"><?php echo $label_tab_dashboard; ?></a></li>
      <li><a href="#tab-setting" data-toggle="tab"><?php echo $label_tab_setting; ?></a></li>
      <li>
        <a href="#tab-update" data-toggle="tab"><?php echo $label_tab_plugin_version; ?>
          <i style="display: none;" id="tab-update-spin" class="fa fa-spinner fa-spin"></i>
          <span id="icon-has-update" style="display: none;" class="text-danger">(<i class="fa fa-bell"></i> 1)</span>
          <span id="icon-up-to-date" style="display: none;" class="text-success">(<i class="fa fa-check"></i>)</span>
          <span id="icon-has-error" style="display: none;" class="text-danger"><i class="fa fa-exclamation"></i></span>
        </a>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Dashboard tab -->
      <div class="tab-pane active in" id="tab-dashboard">
        <?php if ($omise_dashboard['error']) { ?>
          <?php if (is_array($omise_dashboard['error'])) { ?>
              <?php foreach ($omise_dashboard['error'] as $key => $value) { ?>
                <div class="alert alert-danger">
                  <i class="fa fa-exclamation-circle"></i>
                  <?php echo $value; ?>
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              <?php } ?>
          <?php } else { ?>
            <div class="alert alert-danger">
              <i class="fa fa-exclamation-circle"></i>
              <?php echo $omise_dashboard['error']; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php } ?>
        <?php } ?>

        <?php if ($omise_dashboard['enabled'] && !$omise_dashboard['error']) { ?>

          <?php if ($omise_dashboard['warning']) { ?>
            <?php if (is_array($omise_dashboard['warning'])) { ?>
                <?php foreach ($omise_dashboard['warning'] as $key => $value) { ?>
                  <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php echo $value; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>
                <?php } ?>
            <?php } else { ?>
              <div class="alert alert-warning">
                <i class="fa fa-exclamation-circle"></i>
                <?php echo $omise_dashboard['warning']; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
            <?php } ?>
          <?php } ?>

          <div class="box">
            <div class="content">
              <!-- Account Info -->
              <div class="omise-account-info omise-dashboard">
                <dl>
                  <!-- Account email -->
                  <dt><?php echo $label_dashboard_account; ?>: </dt>
                  <dd><?php echo $omise_dashboard['email']; ?></dd>

                  <!-- Account status -->
                  <dt><?php echo $label_dashboard_mode; ?>: </dt>
                  <dd><strong><?php echo $omise_dashboard['livemode'] ? '<span class="livemode-label">' . $text_mode_live . '</span>' : '<span class="testmode-label">' . $text_mode_test . '</span>'; ?></strong></dd>

                  <!-- Current Currency -->
                  <dt><?php echo $label_dashboard_currency; ?>: </dt>
                  <dd><?php echo strtoupper($omise_dashboard['currency']); ?></dd>
                </dl>
              </div>

              <!-- Balance -->
              <div class="omise-balance omise-clearfix">
                <div class="left"><span class="omise-number"><?php echo OmisePluginHelperCurrency::format($omise_dashboard['currency'], $omise_dashboard['total']); ?></span><br/><?php echo $label_dashboard_total_balance; ?></div>
                <div class="right"><span class="omise-number"><?php echo OmisePluginHelperCurrency::format($omise_dashboard['currency'], $omise_dashboard['available']); ?></span><br/><?php echo $label_dashboard_transferable_balance; ?></div>
              </div>

              <!-- Charge History -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $label_dashboard_transactions_history; ?></h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-charge-history" data-toggle="tab"><?php echo $label_tab_charge; ?></a></li>
                    <li><a href="#tab-transfer-history" data-toggle="tab"><?php echo $label_tab_transfer; ?></a></li>
                  </ul>

                  <div class="tab-content">
                    <!-- Tab Charge -->
                    <div class="tab-pane active in" id="tab-charge-history">
                      <form id="omise-transfer" method="post" action="<?php echo $transfer_url; ?>">
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover table-striped">
                            <thead>
                              <tr>
                                <td><?php echo $label_charge_table_amount; ?></td>
                                <td><?php echo $label_charge_table_id; ?></td>
                                <td width="8%"><?php echo $label_charge_table_authorized; ?></td>
                                <td width="8%"><?php echo $label_charge_table_paid; ?></td>
                                <td><?php echo $label_charge_table_failure_message; ?></td>
                                <td class="text-center" width="15%"><?php echo $label_charge_table_created; ?></td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($omise_dashboard['charge_data'] as $key => $value): $date = new \DateTime($value['created']); ?>
                                <tr>
                                  <td><strong class="<?php echo ($value['failure_code']) ? 'text-danger' : ((!$value['authorized'] || !$value['captured']) ? 'text-warning' : 'text-success'); ?>"><?php echo OmisePluginHelperCurrency::format($omise_dashboard['currency'], $value['amount']); ?></strong></td>
                                  <td><a href="https://dashboard.omise.co/<?php echo $value['livemode'] ? 'live' : 'test'; ?>/charges/<?php echo $value['id']; ?>"><?php echo $value['id']; ?></a></td>
                                  <td><?php echo $value['authorized'] ? '<strong class="text-success">Yes</strong>' : 'No'; ?></td>
                                  <td><?php echo $value['captured'] ? '<strong class="text-success">Yes</strong>' : 'No'; ?></td>
                                  <td><?php echo $value['failure_code'] ? '('.$value['failure_code'].') '.$value['failure_code'] : '-'; ?></td>
                                  <td class="text-center"><?php echo $date->format('M d, Y H:i'); ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </form>
                    </div>

                    <!-- Tab Transfer -->
                    <div class="tab-pane fade" id="tab-transfer-history">
                      <form id="omise-transfer" method="post" action="<?php echo $transfer_url; ?>">

                        <div class="table-responsive">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <td><?php echo $label_transfer_table_amount; ?></td>
                                <td><?php echo $label_transfer_table_id; ?></td>
                                <td><?php echo $label_transfer_table_sent; ?></td>
                                <td><?php echo $label_transfer_table_paid; ?></td>
                                <td><?php echo $label_transfer_table_failure_message; ?></td>
                                <td class="text-center" width="15%"><?php echo $label_transfer_table_created; ?></td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($omise_dashboard['transfer_data'] as $key => $value): $date = new \DateTime($value['created']); ?>
                                <tr>
                                  <td><strong class="<?php echo ($value['failure_code']) ? 'text-danger' : ((!$value['sent'] || !$value['paid']) ? 'text-warning' : 'text-success'); ?>"><?php echo OmisePluginHelperCurrency::format($omise_dashboard['currency'], $value['amount']); ?></strong></td>
                                  <td><a href="https://dashboard.omise.co/<?php echo $value['livemode'] ? 'live' : 'test'; ?>/transfers//<?php echo $value['id']; ?>"><?php echo $value['id']; ?></a></td>
                                  <td><?php echo $value['sent'] ? '<strong class="text-success">Yes</strong>' : 'No'; ?></td>
                                  <td><?php echo $value['paid'] ? '<strong class="text-success">Yes</strong>' : 'No'; ?></td>
                                  <td><?php echo $value['failure_code'] ? '('.$value['failure_code'].') '.$value['failure_code'] : '-'; ?></td>
                                  <td class="text-center"><?php echo $date->format('M d, Y H:i'); ?></td>
                                </tr>
                              <?php endforeach; ?>
                              <tr>
                                <td colspan="5" class="text-right"><input style="width: 25%; float:right;" class="form-control" min="0" type="number" step="0.01" name="transfer_amount" placeholder="<?php echo $label_transfer_amount_field_placeholder; ?>"></td>
                                <td class="text-center">
                                  <button type="submit" id="button-transfer" class="btn btn-primary"><?php echo $button_create_transfer; ?>&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
              </div>

            </div> <!-- /END .content -->
          </div> <!-- /END .box -->
        <?php } ?>
      </div>

      <!-- Setting tab -->
      <div class="tab-pane fade" id="tab-setting">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $label_setting_module_config; ?></h3>
            </div>

            <div class="panel-body">
              <!-- Module status -->
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="omise_status"><?php echo $label_setting_module_status; ?></label>
                <div class="col-sm-10">
                  <select name="omise_status" class="form-control">
                    <option value="1" <?php echo $omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                    <option value="0" <?php echo !$omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
                  </select>
                </div>
              </div> <!-- /END Module status (.form-group) -->

              <!-- Payment method title -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payment_title"><?php echo $label_omise_payment_title; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="omise_payment_title" value="<?php echo $omise_payment_title; ?>" id="omise_payment_title" class="form-control" />
                </div>
              </div> <!-- /END Payment method title -->

              <!-- Live mode -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for=""></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <input type="radio" name="omise_test_mode" <?php echo $omise_test_mode == 1 ? 'checked="checked"' : ''; ?> value="1" />
                    <?php echo $label_omise_mode_test; ?>
                  </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label class="radio-inline">
                    <input type="radio" name="omise_test_mode" <?php echo $omise_test_mode == 0 ? 'checked="checked"' : ''; ?> value="0" />
                    <?php echo $label_omise_mode_live; ?>
                  </label>
                </div>
              </div> <!-- /END Live mode (.form-group) -->
            </div> <!-- /END .panel-body -->
          </div> <!-- /END .panel.panel-default -->

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $label_setting_key_config; ?></h3>
            </div>
            <div class="panel-body">
              <!-- Test public key -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_public_key_test"><?php echo $label_omise_pkey_test; ?></label>
                <div class="col-sm-10">
                  <input size="40" type="text" name="omise_pkey_test" value="<?php echo $omise_pkey_test; ?>" id="omise_payments_public_key_test" class="form-control" />
                </div>
              </div>

              <!-- Test secret key -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_secret_key_test"><?php echo $label_omise_skey_test; ?></label>
                <div class="col-sm-10">
                  <input size="40" type="password" name="omise_skey_test" value="<?php echo $omise_skey_test; ?>" id="omise_payments_secret_key_test" class="form-control" />
                </div>
              </div>

              <!-- Live public key -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_public_key"><?php echo $label_omise_pkey; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="omise_pkey" value="<?php echo $omise_pkey; ?>" id="omise_payments_public_key" class="form-control" />
                </div>
              </div>

              <!-- Live secret key -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_public_key"><?php echo $label_omise_skey; ?></label>
                <div class="col-sm-10">
                  <input type="password" name="omise_skey" value="<?php echo $omise_skey; ?>" id="omise_payments_secret_key" class="form-control" />
                </div>
              </div>
            </div>
          </div> <!-- /END .panel.panel-default -->

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $label_setting_omise_config; ?></h3>
            </div>
            <div class="panel-body">
              <!-- Payment Action -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_auto_capture"><?php echo $label_omise_payment_action; ?></label>
                <div class="col-sm-10">
                  <select name="omise_auto_capture" id="omise_auto_capture" class="form-control">
                    <option value="1" <?php echo $omise_auto_capture ? 'selected="selected"' : ''; ?>><?php echo $text_auto_capture; ?></option>
                    <option value="0" <?php echo !$omise_auto_capture ? 'selected="selected"' : ''; ?>><?php echo $text_manual_capture; ?></option>
                  </select>
                </div>
              </div> <!-- /END Payment Action -->
            </div>
          </div>
        </form>
      </div>

      <!-- Update tab -->
      <div class="tab-pane fade" id="tab-update">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $label_tab_plugin_version; ?></h3>
          </div>

          <div class="panel-body text-center">
            <p id="box-label"><?php echo $text_checking_for_latest_version; ?></p>
            <div style="display: none;" id="omise-update-instruction"></div>
          </div>
        </div>
      </div>
    </div>


  </div> <!-- /END .container-fluid -->
</div> <!-- /END #content -->

<!-- Include Omise's stylesheet -->
<link rel="stylesheet" type="text/css" href="view/stylesheet/omise.css">
<script>
  var url = '<?php echo $versioncheckup_url; ?>';
      url = url.replace('&amp;', '&');

  var hasUpdate = function(data) {
    $("#icon-has-update").show();
    $("#box-label")
      .addClass('text-danger')
      .html('Your Omise-OpenCart version (v'+data.current_version+') is too old.');

    $("#omise-update-instruction")
      .html('\
        <div><a href="'+data.released.zipball_url+'" class="btn btn-primary">Download ZIP</a>&nbsp;<a href="'+data.released.tarball_url+'" class="btn btn-primary">Download TAR.GZ</a></div>\
        <div style="margin-top: 15px;">see more information: <a href="'+data.released.html_url+'">'+data.released.html_url+'</a></div>\
      ')
      .show();
  }

  var isUpToDate = function(data) {
    $("#icon-up-to-date").show();
    $("#box-label")
      .addClass('text-success')
      .html('Your Omise-OpenCart version (v'+data.current_version+') is up to date.');
  }

  var isFailed = function(data) {
    $("#icon-has-error").show();
    $("#box-label")
      .addClass('text-danger')
      .html(data.error_messsage);
  }

  $.ajax({
    url: url,
    type: 'GET',
    beforeSend: function() {
      $("#tab-update-spin").show();
    },
    success: function(data, textStatus, jqXHR) {
      $("#tab-update-spin").hide();

      data = $.parseJSON(data);

      if (data.status === "connected" && data.has_update) {
        hasUpdate(data);

      } else if (data.status === "connected") {
        isUpToDate(data);

      } else if (data.status === "failed") {
        isFailed(data);
      }
    },
    error: function(data, textStatus, jqXHR) {
      $("#icon-has-error").show();
      $("#box-label")
          .addClass('text-danger')
          .html('Failed to connect to the server for get an update.');
    }
  });
</script>

<?php echo $footer; ?>
