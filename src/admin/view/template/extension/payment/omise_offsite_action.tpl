<div id="action"></div>
<br />
<dl>
  <dt>Order Status:</dt>
  <dd id="order-status-action"><?= $order_status['name'] ?></dd>
</dl>
<button id="button-refresh" data-loading-text="<?= $text_loading; ?>" class="btn btn-primary" style="display: none;"><i class="fa fa-refresh"></i> <?= $button_refresh; ?></button>
<script type="text/javascript"><!--
$(document).ready(function() {
  if ($('select[name="order_status_id"]').val() == 2) {
    $('#button-refresh').show();
  }
});
$('#button-history').on('click', function() {
  if ($('select[name="order_status_id"]').val() == 2) {
    $('#order-status-action').html($('select[name=\'order_status_id\'] option:selected').text());
    $('#button-refresh').show();
  }
});
$('#button-refresh').on('click', function() {
  $.ajax({
    url: 'index.php?route=sale/order/api&api=payment/omise/refresh&token=<?= $token ?>&order_id=<?= $order_id ?>',
    type: 'get',
    dataType: 'json',
    beforeSend: function() {
      $('#button-refresh').button('loading');
    },
    complete: function() {
      $('#button-refresh').button('reset');
    },
    success: function(json) {
      $('.alert').remove();

      if (json['error']) {
        $('#action').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['success']) {
        $('#action').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['new_status']) {
        $('#order-status').text(json['new_status']);
        $('#order-status-action').text(json['new_status']);
        $('#button-refresh').hide();
        $('select[name="order_status_id"]').val(json['new_status_id']); 

        // cloned from sales/order/info
        $('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
//--></script>
