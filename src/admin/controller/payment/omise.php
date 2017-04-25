<?php
class ControllerPaymentOmise extends Controller {
	/**
	 * @var array
	 */
	private $error = array();

	/**
	 * @return string
	 */
	private function flashSuccessMessages() {
		if (isset($this->session->data['success'])) {
			$msg = $this->session->data['success'];
			unset($this->session->data['success']);

			return $msg;
		}

		return "";
	}

	/**
	 * @return string
	 */
	private function flashErrorMessages() {
		if (isset($this->session->data['error'])) {
			$msg = $this->session->data['error'];
			unset($this->session->data['error']);

			return $msg;
		}

		return "";
	}

	/**
	 * Set page breadcrumb
	 * @return array
	 */
	private function setBreadcrumb($current = null) {
		$this->load->language('payment/omise');

		// Set Breadcrumbs.
		$breadcrumbs = array();

		$breadcrumbs[] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$breadcrumbs[] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$breadcrumbs[] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (! is_null($current))
			$breadcrumbs[] = $current;

		return $breadcrumbs;
	}

	/**
	 * @return array
	 */
	private function pageDataDashboardTab() {
		$this->load->language('payment/omise');
		$this->load->library('omise');
		$this->load->model('localisation/currency');
		$this->load->model('payment/omise');

		$data = array();
		$data['omise_dashboard'] = array(
			'enabled' => $this->config->get('omise_status'),
			'error'   => '',
			'warning' => '',
		);

		if (! $data['omise_dashboard']['enabled']) {
			$data['omise_dashboard']['error'][] = $this->language->get('error_extension_disabled');
		} else {
			try {
				// Retrieve Omise Account.
				$omise_account = $this->model_payment_omise->getOmiseAccount();
				if (isset($omise_account['error']))
					throw new Exception('Omise Account '.$omise_account['error'], 1);

				// Retrieve Omise Balance.
				$omise_balance = $this->model_payment_omise->getOmiseBalance();
				if (isset($omise_balance['error']))
					throw new Exception('Omise Balance '.$omise_balance['error'], 1);

				// Retrieve Omise Charge List.
				$omise_charge = $this->model_payment_omise->getOmiseChargeList();
				if (isset($omise_charge['error']))
					throw new Exception('Omise Charge '.$omise_charge['error'], 1);

				// Retrieve Omise Transfer List.
				$omise_transfer = $this->model_payment_omise->getOmiseTransferList();
				if (isset($omise_transfer['error']))
					throw new Exception('Omise Transfer '.$omise_transfer['error'], 1);

				$data['omise_dashboard'] = array_merge(
					$data['omise_dashboard'],
					array(
						'email'          => $omise_account['email'],
						'created'        => $omise_account['created'],
						'livemode'       => $omise_balance['livemode'],
						'currency'       => $omise_balance['currency'],
						'available'      => $omise_balance['available'],
						'total'          => $omise_balance['total'],
						'charge_data'    => $omise_charge['data'],
						'charge_total'   => $omise_charge['total'],
						'transfer_data'  => $omise_transfer['data'],
						'transfer_total' => $omise_transfer['total'],
					)
				);

				// Check currency supports
				if (! OmisePluginHelperCurrency::isSupport($this->config->get('config_currency'))) {
					$data['omise_dashboard']['warning'][] = sprintf(
						$this->language->get('error_currency_not_support'),
						$this->config->get('config_currency'),
						$this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL')
					);
				}
			} catch (Exception $e) {
				$data['omise_dashboard']['error'][] = $this->searchErrorTranslation($e->getMessage());
			}
		}

		return $data;
	}

	/**
	 * @return array
	 */
	private function pageDataSettingTab() {
		$this->load->model('payment/omise');

		if (is_null($this->config->get('omise_auto_capture'))) {
			$omise_auto_capture = $this->model_payment_omise->getDefaultAutoCapture();
		} else {
			$omise_auto_capture = $this->config->get('omise_auto_capture');
		}

		return array(
			'omise_status'        => $this->config->get('omise_status'),
			'omise_test_mode'     => $this->config->get('omise_test_mode'),
			'omise_3ds'           => $this->config->get('omise_3ds'),
			'omise_pkey_test'     => $this->config->get('omise_pkey_test'),
			'omise_skey_test'     => $this->config->get('omise_skey_test'),
			'omise_pkey'          => $this->config->get('omise_pkey'),
			'omise_skey'          => $this->config->get('omise_skey'),
			'omise_payment_title' => $this->config->get('omise_payment_title'),
			'omise_auto_capture'  => $omise_auto_capture
		);
	}

	/**
	 * @return array
	 */
	private function pageTranslation() {
		$this->load->language('payment/omise');

		return array(
			'heading_title'                           => $this->language->get('heading_title'),
			'label_tab_dashboard'                     => $this->language->get('label_tab_dashboard'),
			'label_tab_setting'                       => $this->language->get('label_tab_setting'),
			'label_tab_plugin_version'                => $this->language->get('label_tab_plugin_version'),
			'label_tab_charge'                        => $this->language->get('label_tab_charge'),
			'label_tab_transfer'                      => $this->language->get('label_tab_transfer'),
			'label_dashboard_account'                 => $this->language->get('label_dashboard_account'),
			'label_dashboard_mode'                    => $this->language->get('label_dashboard_mode'),
			'label_dashboard_currency'                => $this->language->get('label_dashboard_currency'),
			'label_dashboard_total_balance'           => $this->language->get('label_dashboard_total_balance'),
			'label_dashboard_transferable_balance'    => $this->language->get('label_dashboard_transferable_balance'),
			'label_dashboard_transactions_history'    => $this->language->get('label_dashboard_transactions_history'),
			'label_charge_table_no'                   => $this->language->get('label_charge_table_no'),
			'label_charge_table_amount'               => $this->language->get('label_charge_table_amount'),
			'label_charge_table_id'                   => $this->language->get('label_charge_table_id'),
			'label_charge_table_authorized'           => $this->language->get('label_charge_table_authorized'),
			'label_charge_table_paid'                 => $this->language->get('label_charge_table_paid'),
			'label_charge_table_failure_message'      => $this->language->get('label_charge_table_failure_message'),
			'label_charge_table_created'              => $this->language->get('label_charge_table_created'),
			'label_transfer_table_no'                 => $this->language->get('label_transfer_table_no'),
			'label_transfer_table_amount'             => $this->language->get('label_transfer_table_amount'),
			'label_transfer_table_id'                 => $this->language->get('label_transfer_table_id'),
			'label_transfer_table_sent'               => $this->language->get('label_transfer_table_sent'),
			'label_transfer_table_paid'               => $this->language->get('label_transfer_table_paid'),
			'label_transfer_table_failure_message'    => $this->language->get('label_transfer_table_failure_message'),
			'label_transfer_table_created'            => $this->language->get('label_transfer_table_created'),
			'label_transfer_amount_field_placeholder' => $this->language->get('label_transfer_amount_field_placeholder'),
			'label_setting_module_config'             => $this->language->get('label_setting_module_config'),
			'label_setting_module_status'             => $this->language->get('label_setting_module_status'),
			'label_setting_key_config'                => $this->language->get('label_setting_key_config'),
			'label_setting_omise_config'              => $this->language->get('label_setting_omise_config'),
			'label_omise_pkey_test'                   => $this->language->get('label_omise_pkey_test'),
			'label_omise_skey_test'                   => $this->language->get('label_omise_skey_test'),
			'label_omise_pkey'                        => $this->language->get('label_omise_pkey'),
			'label_omise_skey'                        => $this->language->get('label_omise_skey'),
			'label_omise_mode_test'                   => $this->language->get('label_omise_mode_test'),
			'label_omise_mode_live'                   => $this->language->get('label_omise_mode_live'),
			'label_omise_3ds'                         => $this->language->get('label_omise_3ds'),
			'label_omise_payment_title'               => $this->language->get('label_omise_payment_title'),
			'label_omise_payment_action'              => $this->language->get('label_omise_payment_action'),
			'text_mode_test'                          => $this->language->get('text_mode_test'),
			'text_mode_live'                          => $this->language->get('text_mode_live'),
			'text_enabled'                            => $this->language->get('text_enabled'),
			'text_disabled'                           => $this->language->get('text_disabled'),
			'text_checking_for_latest_version'        => $this->language->get('text_checking_for_latest_version'),
			'text_version_up_to_date'                 => $this->language->get('text_version_up_to_date'),
			'text_auto_capture'                       => $this->language->get('text_auto_capture'),
			'text_manual_capture'                     => $this->language->get('text_manual_capture'),
			'button_save'                             => $this->language->get('button_save'),
			'button_cancel'                           => $this->language->get('button_cancel'),
			'button_create_transfer'                  => $this->language->get('button_create_transfer'),
		);
	}

	/**
	 * @return string
	 */
	private function searchErrorTranslation($clue) {
		$this->load->language('payment/omise');

		$translate_code = 'error_' . str_replace(' ', '_', strtolower($clue));
		$translate_msg  = $this->language->get($translate_code);

		if ($translate_code !== $translate_msg)
			return $translate_msg;

		return $clue;
	}

	/**
	 * @return void
	 */
	private function redirectTo($destination) {
		switch ($destination) {
			case 'omise_dashboard':
				$this->response->redirect($this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'));
				break;

			default:
				$this->response->redirect($this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'));
				break;
		}
	}

	/**
	 * This method will fire when user click `install` button from `extension/payment` page
	 * It will call `model/payment/omise.php` file and run `install` method for installl stuff
	 * that necessary to use in Omise Payment Gateway module
	 * @return void
	 */
	public function install() {
		$this->load->model('payment/omise');

		try {
			// Install the extension
			if (! $this->model_payment_omise->install())
				throw new Exception('', 1);
		} catch (Exception $e) {
			// Uninstall
			$this->load->controller('extension/payment/uninstall');
		}
	}

	/**
	 * This method will fire when user click `Uninstall` button from `extension/payment` page
	 * Uninstall everything that related with Omise Payment Gateway module.
	 * @return void
	 */
	public function uninstall() {

	}

	/**
	 * (GET) Page, route=payment/omise
	 */
	public function index() {
		// POST Request handle
		if (($this->request->server['REQUEST_METHOD'] == 'POST'))
			$this->updateConfig();

		$this->load->language('payment/omise');
		$this->document->setTitle($this->language->get('heading_title'));

		// Manipulate page's data
		$data = array_merge(
			$this->pageDataDashboardTab(),
			$this->pageDataSettingTab(),
			$this->pageTranslation(),
			array(
				'success'            => $this->flashSuccessMessages(),
				'error_warning'      => $this->flashErrorMessages(),
				'action'             => $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'),
				'cancel'             => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'transfer_url'       => $this->url->link('payment/omise/submittransfer', 'token=' . $this->session->data['token'], 'SSL'),
				'versioncheckup_url' => $this->url->link('payment/omise/ajaxversioncheckup', 'token=' . $this->session->data['token'], 'SSL'),
			)
		);

		// Page templates
		$data = array_merge($data, array(
			'header'      => $this->load->controller('common/header'),
			'breadcrumbs' => $this->setBreadcrumb(null),
			'column_left' => $this->load->controller('common/column_left'),
			'footer'      => $this->load->controller('common/footer')
		));

		$this->response->setOutput($this->load->view('payment/omise.tpl', $data));
	}

	/**
	 * (POST)
	 * @return void
	 */
	public function updateConfig() {
		$this->load->model('setting/setting');
		$this->load->language('payment/omise');

		try {
			// Allowed only POST method
			if ($this->request->server['REQUEST_METHOD'] !== 'POST')
				throw new Exception($this->language->get('error_allowed_only_post_method'), 1);

			$update = $this->request->post;
			if (! empty($update)) {
				$update['omise_3ds'] = isset($update['omise_3ds']) ? $update['omise_3ds'] : 0;

				// Update
				$this->model_setting_setting->editSetting('omise', $update);
				$this->session->data['success'] = $this->language->get('text_session_save');
			}
		} catch (Exception $e) {
			$this->session->data['error'] = $this->searchErrorTranslation($e->getMessage());
		}

		$this->redirectTo('omise_dashboard');
	}

	/**
	 * Submit a transfer request to Omise server
	 * @return void
	 */
	public function submitTransfer() {
		$this->load->model('payment/omise');
		$this->load->language('payment/omise');

		try {
			// Allowed only POST method
			if (! $this->request->server['REQUEST_METHOD'] === 'POST')
				throw new Exception($this->language->get('error_allowed_only_post_method'), 1);

			// Required 'transfer_amount' and transfer_amount must be greater than 0
			if (! isset($this->request->post['transfer_amount']) || $this->request->post['transfer_amount'] <= 0)
				throw new Exception($this->language->get('error_transfer_amount_is_empty'), 1);

			$transferring = $this->model_payment_omise->createOmiseTransfer($this->request->post['transfer_amount']);
			if (isset($transferring['error']))
				throw new Exception('Omise Transfer '.$transferring['error'], 1);

			$this->session->data['success'] = $this->language->get('text_omise_transfer_success');
		} catch (Exception $e) {
			$this->session->data['error'] = $this->searchErrorTranslation($e->getMessage());
		}

		$this->redirectTo('omise_dashboard');
	}

	/**
	 * Get the latest version number of Omise-OpenCart from Github.
	 * @return string (json)
	 */
	public function ajaxVersionCheckup() {
		$this->load->library('omise');

		$ch = curl_init('https://api.github.com/repos/omise/omise-opencart/releases');
		curl_setopt_array($ch, array(
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => 'GET',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLINFO_HEADER_OUT    => true,
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_USERAGENT      => OMISE_USER_AGENT_SUFFIX
		));

		try {
			// Make a request or thrown an exception.
			if(($result = curl_exec($ch)) === false) {
				$error = curl_error($ch);
				curl_close($ch);

				throw new Exception($error);
			}

			// Close.
			curl_close($ch);

			$current = strtotime(OMISE_OPENCART_RELEASED_DATE);
			$data    = null;
			$result  = json_decode($result);
			if (!empty($result)) {
				foreach ($result as $key => $value) {
					if ($current < strtotime($value->created_at)) {
						$current = strtotime($value->created_at);
						$data = $value;
					}
				}
			}

			echo json_encode(array(
				'status'          => 'connected',
				'has_update'      => (strtotime(OMISE_OPENCART_RELEASED_DATE) != $current) ? true : false,
				'released'        => $data,
				'current_version' => OMISE_OPENCART_VERSION
			));
		} catch (Exception $e) {
			echo json_encode(array(
				'status'          => 'failed',
				'error_messsage'  => $e->getMessage()
			));
		}
	}
}