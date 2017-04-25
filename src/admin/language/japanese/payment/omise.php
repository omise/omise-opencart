<?php
// Module title
$_['heading_title']                                            = 'Omise Payment Gateway';
$_['text_omise']                                               = '<a href="https://www.omise.co/ja" target="_blank" style="border: 1px solid #EEEEEE; padding: 2px; width: 94px; max-height:25px; display: inline-block;" alt="Omise Payment Gateway"" title="Omise Payment Gateway"><img src="view/image/payment/omise-payment.png" alt="Omise Payment Gateway"" title="Omise Payment Gateway" style="max-height:18px;" /></a>';


// Labels
$_['label_tab_dashboard']                                      = 'ダッシュボード';
$_['label_tab_setting']                                        = '設定';
$_['label_tab_plugin_version']                                 = 'プラグインバージョン';
$_['label_tab_charge']                                         = '課金';
$_['label_tab_transfer']                                       = '振込';
$_['label_dashboard_account']                                  = 'アカウント';
$_['label_dashboard_mode']                                     = 'モード';
$_['label_dashboard_currency']                                 = '通貨';
$_['label_dashboard_total_balance']                            = '総残高';
$_['label_dashboard_transferable_balance']                     = '振込可能残高';
$_['label_dashboard_transactions_history']                     = '決済履歴';
$_['label_charge_table_no']                                    = 'No.';
$_['label_charge_table_amount']                                = '金額';
$_['label_charge_table_id']                                    = '課金ID';
$_['label_charge_table_authorized']                            = '認証済';
$_['label_charge_table_paid']                                  = '振込済';
$_['label_charge_table_failure_message']                       = '失敗メッセージ';
$_['label_charge_table_created']                               = '作成済み';
$_['label_transfer_table_no']                                  = 'No.';
$_['label_transfer_table_amount']                              = '金額';
$_['label_transfer_table_id']                                  = '振込ID';
$_['label_transfer_table_sent']                                = '送信済';
$_['label_transfer_table_paid']                                = '振込済';
$_['label_transfer_table_failure_message']                     = '失敗メッセージ';
$_['label_transfer_table_created']                             = '作成済';
$_['label_transfer_amount_field_placeholder']                  = '振込金額 (数字のみ)';
$_['label_setting_module_config']                              = 'モジュール設定';
$_['label_setting_module_status']                              = 'モジュール状況';
$_['label_setting_key_config']                                 = 'Omise キー設定';
$_['label_setting_omise_config']                               = 'Omise 統合サービス';


// Omise's labels
$_['label_omise_pkey_test']                                    = '試験用パブリックキー';
$_['label_omise_skey_test']                                    = '試験用シークレットキー';
$_['label_omise_mode_test']                                    = 'テストモードの有効化';
$_['label_omise_mode_live']                                    = 'ライブモードの有効化';
$_['label_omise_pkey']                                         = 'パブリックキー';
$_['label_omise_skey']                                         = 'シークレットキー';
$_['label_omise_3ds']                                          = '3Dセキュアの有効化';
$_['label_omise_payment_title']                                = '決済方法';
$_['label_omise_payment_action']                               = '売上処理方法';


// Breadcrumb menu.
$_['text_home']                                                = 'ホーム';
$_['text_payment']                                             = '決済';


// Messages
$_['text_mode_test']                                           = 'テスト';
$_['text_mode_live']                                           = 'ライブ';
$_['text_enabled']                                             = '有効化';
$_['text_disabled']                                            = '無効化';
$_['text_checking_for_latest_version']                         = '最新のバージョンを確認しています';
$_['text_version_up_to_date']                                  = 'お使いの Omise-OpenCart のバージョンは最新です';
$_['text_session_save']                                        = '保存されました';
$_['text_omise_transfer_success']                              = '振込要求が送信されました';
$_['text_auto_capture']                                        = '自動売上';
$_['text_manual_capture']                                      = '手動売上';


// Action buttons
$_['button_save']                                              = '保存';
$_['button_cancel']                                            = 'キャンセル';
$_['button_create_transfer']                                   = '振込の要求';


// Errors
$_['error_extension_disabled']                                 = 'Omiseペイメントゲートウェイの extension を有効化してください（\'設定\' タブを確認してください)';
$_['error_currency_not_support']                               = '現在、対応可能な通貨はタイバーツ(THB)、インドネシアルピア(IDR)、日本円(JPY)とシンガポールドル(SGD)のみとなっております。あなたのデフォルト通貨は<strong>%s</strong>に設定されています。<a href="%s">セットアップ</a> もしくは <a href="http://docs.opencart.com/system/setting/local">詳しく知る</a>';
$_['error_transfer_amount_is_empty']                           = '振込希望金額を入力、送信してください。';
$_['error_allowed_only_post_method']                           = '振込金額に問題があります。';


// Omise's API errors
$_['error_omise_account_authentication_failed']                = 'Omiseの承認キーが正しくありません';
$_['error_omise_transfer_amount_must_be_greater_than_260_jpy'] = 'Transfer amount must be greater than 260 YEN';
$_['error_omise_transfer_amount_must_be_greater_than_30_thb']  = 'Transfer amount must be greater than 30 THB';









$_['button_setting']                    = '設定';

// Session message
$_['text_session_error']                = 'Something wrong.';

/**
 * Error Message.
 *
 */
$_['error_omise_table_install_failed']  = 'Can not create Omise table now, something wrong.';


