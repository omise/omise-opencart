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
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>
    <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>

    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab-dashboard" data-toggle="tab">Dashboard</a></li>
      <li><a href="#tab-setting" data-toggle="tab">Setting</a></li>
    </ul>

    <div class="tab-content">
      <!-- Dashboard tab -->
      <div class="tab-pane active in" id="tab-dashboard">
        <?php if ($omise_dashboard['error_warning']) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $omise_dashboard['error_warning']; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
          </div>
        <?php } ?>

        <?php if ($omise_dashboard['enabled'] && !$omise_dashboard['error_warning']) { ?>
          <div class="box">
            <div class="content">
              <!-- Account Info -->
              <div class="omise-account-info omise-dashboard">
                <dl>
                  <!-- Account email -->
                  <dt>Account: </dt>
                  <dd><?php echo $omise_dashboard['account']['email']; ?></dd>

                  <!-- Account status -->
                  <dt>Mode: </dt>
                  <dd><strong><?php echo $omise_dashboard['balance']['livemode'] ? '<span class="livemode-label">Live</span>' : '<span class="testmode-label">Test</span>'; ?></strong></dd>

                  <!-- Current Currency -->
                  <dt>Currency: </dt>
                  <dd><?php echo strtoupper($omise_dashboard['balance']['currency']); ?></dd>
                </dl>
              </div>

              <!-- Balance -->
              <div class="omise-balance omise-clearfix">
                <div class="left"><span class="omise-number"><?php echo number_format(($omise_dashboard['balance']['total']/100), 2); ?></span><br/>Total Balance</div>
                <div class="right"><span class="omise-number"><?php echo number_format(($omise_dashboard['balance']['available']/100), 2); ?></span><br/>Transferable Balance</div>
              </div>

              <!-- Transfer History -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-list"></i> Transfer History</h3>
                </div>
                <div class="panel-body">
                  <form id="omise-transfer" method="post" action="<?php echo $transfer_url; ?>">
                    
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <td class="text-left">Amount</td>
                            <td class="text-left">Transfer Id</td>
                            <td class="text-left">Sent</td>
                            <td class="text-left">Paid</td>
                            <td class="text-left">Failure Message</td>
                            <td class="text-center" width="15%">Created</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($omise_dashboard['transfer']['data'] as $key => $value): $date = new \DateTime($value['created']); ?>
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
                            <td colspan="5" class="right"><input style="width: 25%;float:right;" class="form-control" min="0" type="number" name="transfer_amount" placeholder="Transfer amount (number only)"></td>
                            <td style="text-align: center;">
                              <button type="submit" id="button-transfer" class="btn btn-primary pull-right">Create transfer&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </form>
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
              <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>

            <div class="panel-body">
              <!-- Module config -->
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="omise_status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="omise_status" class="form-control">
                    <option value="1" <?php echo $omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                    <option value="0" <?php echo !$omise_status ? 'selected="selected"' : ''; ?>><?php echo $text_disabled; ?></option>
                  </select>
                </div>
              </div> <!-- /END Module config (.form-group) -->

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-username"></label>
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
              </div> <!-- /END Module config (.form-group) -->
            </div> <!-- /END .panel-body -->
          </div> <!-- /END .panel.panel-default -->

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-pencil"></i> Omise Keys Config</h3>
            </div>
            <div class="panel-body">
              <!-- Test public key -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_public_key_test"><?php echo $label_omise_pkey_test; ?></label>
                <div class="col-sm-10">
                  <input size="40" type="password" name="omise_pkey_test" value="<?php echo $omise_pkey_test; ?>" id="omise_payments_public_key_test" class="form-control" />
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
                  <input type="password" name="omise_pkey" value="<?php echo $omise_pkey; ?>" id="omise_payments_public_key" class="form-control" />
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
              <h3 class="panel-title"><i class="fa fa-pencil"></i> Omise Advance Integration</h3>
            </div>
            <div class="panel-body">
              <!-- 3D-Secure -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="omise_payments_3ds"><?php echo $label_omise_3ds; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <input type="checkbox" name="omise_3ds" value="1" class="form-control" <?php echo $omise_3ds ? 'checked="checked"' : ''; ?> />
                  </div>
                </div>
              </div> <!-- /END .3D-Secure -->
            </div>
          </div>
        </form>
      </div>
    </div>

    
  </div> <!-- /END .container-fluid -->
</div> <!-- /END #content -->

<!-- Include Omise's stylesheet -->
<link rel="stylesheet" type="text/css" href="view/stylesheet/omise.css">

<?php echo $footer; ?>

