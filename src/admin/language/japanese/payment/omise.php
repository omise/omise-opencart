<?php
// Module title
$_['heading_title']                             = 'Omise Payment Gateway (JP)';
$_['text_omise']                                = '<a href="https://www.omise.co/ja" target="_blank" style="border: 1px solid #EEEEEE; padding: 2px; width: 94px; max-height:25px; display: inline-block;" alt="Omise Payment Gateway"" title="Omise Payment Gateway"><img src="view/image/payment/omise-payment.png" alt="Omise Payment Gateway"" title="Omise Payment Gateway" style="max-height:18px;" /></a>';


// Labels
$_['label_tab_dashboard']                       = 'ダッシュボード';
$_['label_tab_setting']                         = '設定';
$_['label_tab_plugin_version']                  = 'プラグインのバージョン';
$_['label_tab_charge']                          = 'Charge <3';
$_['label_tab_transfer']                        = 'Transfer <3';
$_['label_dashboard_account']                   = 'アカウント';
$_['label_dashboard_mode']                      = 'モード';
$_['label_dashboard_currency']                  = '通貨';
$_['label_dashboard_total_balance']             = 'Total Balance <3';
$_['label_dashboard_transferable_balance']      = 'Transferable Balance <3';
$_['label_dashboard_transactions_history']      = '取引履歴';
$_['label_charge_table_no']                     = 'No. <3';
$_['label_charge_table_amount']                 = 'Amount <3';
$_['label_charge_table_id']                     = 'Charge Id <3';
$_['label_charge_table_authorized']             = 'Authorized <3';
$_['label_charge_table_paid']                   = 'Paid <3';
$_['label_charge_table_failure_message']        = 'Failure Message <3';
$_['label_charge_table_created']                = 'Created <3';
$_['label_transfer_table_no']                   = 'No. <3';
$_['label_transfer_table_amount']               = 'Amount <3';
$_['label_transfer_table_id']                   = 'Transfer Id <3';
$_['label_transfer_table_sent']                 = 'Sent <3';
$_['label_transfer_table_paid']                 = 'Paid <3';
$_['label_transfer_table_failure_message']      = 'Failure Message <3';
$_['label_transfer_table_created']              = 'Created <3';
$_['label_transfer_amount_field_placeholder']   = 'Transfer amount (number only) <3';
$_['label_setting_module_config']               = 'Module Config <3';
$_['label_setting_module_status']               = 'Module Status <3';
$_['label_setting_key_config']                  = 'Omise Keys Config <3';
$_['label_setting_omise_config']                = 'Omise Advance Integration <3';


// Omise's labels
$_['label_omise_pkey_test']                     = 'Public Key for test <3';
$_['label_omise_skey_test']                     = 'Secret Key for test <3';
$_['label_omise_mode_test']                     = 'Enable test mode <3';
$_['label_omise_mode_live']                     = 'Enable live mode <3';
$_['label_omise_pkey']                          = 'Public Key <3';
$_['label_omise_skey']                          = 'Secret Key <3';
$_['label_omise_3ds']                           = 'Enable 3D-Secure <3';
$_['label_omise_payment_title']                 = 'Payment method title <3';


// Messages
$_['text_mode_test']                            = 'Test';
$_['text_mode_live']                            = 'Live';
$_['text_enabled']                              = 'Enabled <3';
$_['text_disabled']                             = 'Disabled <3';
$_['text_checking_for_latest_version']          = 'Checking for latest version... <3';
$_['text_version_up_to_date']                   = 'Your Omise-OpenCart version is up to date. <3';


// Action buttons
$_['button_save']                               = 'セーブ';
$_['button_cancel']                             = 'キャンセル';
$_['button_create_transfer']                    = 'Create transfer <3';


// Errors
$_['error_extension_disabled']                  = 'Please enable Omise Payment Gateway extension (check \'設定\' tab).';
$_['error_currency_thb_not_found']              = 'Thai Baht (THB) 通貨 was not found from your system. <a href="%s">setup</a> or <a href="http://docs.opencart.com/system/localisation/currency">learn more</a>';
$_['error_currency_jpy_not_found']              = 'Japanese Yen (JPY) 通貨 was not found from your system. <a href="%s">setup</a> or <a href="http://docs.opencart.com/system/localisation/currency">learn more</a>';
$_['error_currency_not_support']                = 'Currently, we only support Thai Baht (THB) and Japanese Yen (JPY). Your default 通貨 is <strong>%s</strong>. <a href="%s">setup</a> or <a href="http://docs.opencart.com/system/setting/local">learn more</a>';


// Omise's API errors
$_['error_omise_account_authentication_failed'] = 'Omise\'s authentication keys are wrong :<';








// Breadcrumb menu.
$_['text_home']                         = 'Home';
$_['text_payment']                      = 'Payments';

$_['button_setting']                    = 'Setting';

// Session message
$_['text_session_save']                 = 'Saved.';
$_['text_session_error']                = 'Something wrong.';

// 3. Transfer API Response
$_['api_transfer_success']              = 'Your transfer request has sent already.';

/**
 * Error Message.
 *
 */
$_['error_omise_table_install_failed']  = 'Can not create Omise table now, something wrong.';


$_['error_needed_post_request']         = 'Wrong to request to transfer your amount.';
$_['error_need_amount_value']           = 'Please submit your amount that you want to transfer.';
?>