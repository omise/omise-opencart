<?php
$_['heading_title'] = 'Omise Payment Gateway';
$_['text_omise']    = '<a href="https://www.omise.co" target="_blank" style="border: 1px solid #EEEEEE; padding: 2px; width: 94px; max-height:25px; display: inline-block;" alt="Omise Payment Gateway"" title="Omise Payment Gateway"><img src="view/image/payment/omise-payment.png" alt="Omise Payment Gateway"" title="Omise Payment Gateway" style="max-height:18px;" /></a>';


// Breadcrumb menu.
$_['text_home']          = 'Home';
$_['text_payment']       = 'Payments';

// Extension status
$_['entry_status']       = 'Module Status:';

// Action buttons
$_['button_save']        = 'Save';
$_['button_cancel']      = 'Cancel';
$_['button_setting']     = 'Setting';

// Session message
$_['text_session_save']  = 'Saved.';
$_['text_session_error'] = 'Something wrong.';


/**
 * Setting page.
 * - 1. Message in the setting page
 * - 2. Omise text
 * - 3. Transfer API Response
 */
// 1. Message in the setting page
$_['text_form']                 = 'Module Config';
$_['text_enabled']              = 'Enabled';
$_['text_disabled']             = 'Disabled';

// 2. Omise text.
$_['label_omise_pkey_test']     = 'Public Key for test';
$_['label_omise_skey_test']     = 'Secret Key for test';
$_['label_omise_mode_test']     = 'Enable test mode';
$_['label_omise_mode_live']     = 'Enable live mode';
$_['label_omise_pkey']          = 'Public Key';
$_['label_omise_skey']          = 'Secret Key';
$_['label_omise_3ds']           = 'Enable 3D-Secure';
$_['label_omise_payment_title'] = 'Payment method title';

// 3. Transfer API Response
$_['api_transfer_success']      = 'Sent your transfer request already, please waiting for comfirmation from the bank.';


/**
 * Error Message.
 *
 */
$_['error_omise_table_install_failed']  = 'Can not create Omise table now, something wrong.';
$_['error_extension_disabled']          = 'Please enable Omise Payment Gateway extension before (check \'Setting\' tab).';
// $_['error_omise_menu_xml_not_exists']   = 'omise_menu.xml not found in install folder, please check.';
// $_['error_vqmod_xml_not_exists']        = 'vQmod\'s xml folder does not exists.';
// $_['error_file_not_writable']           = 'File not writable, please give it the writable permission.';
// $_['error_file_permission_denied']      = 'Permission denied, please give it the permission.';
// $_['error_can_not_copy_file']           = 'File not copy, please give it the permission.';
$_['error_needed_post_request']         = 'Wrong to request to transfer your amount.';
$_['error_need_amount_value']           = 'Please submit your amount that you want to transfer.';
// $_['error_general_error']               = 'Something went wrong, please contact an Omise via https://support.omise.co/hc/en-us. sorry for your inconvenience.';

?>