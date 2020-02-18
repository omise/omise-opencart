<?php
class ControllerExtensionPaymentOmiseOffsite extends Controller {
	/**
	 * @return string
	 */
	private function searchErrorTranslation($clue) {
		$this->load->language('extension/payment/omise_offsite');

		$translate_code = 'error_' . str_replace(' ', '_', strtolower($clue));
		$translate_msg  = $this->language->get($translate_code);

		if ($translate_code !== $translate_msg) {
			return $translate_msg;
		}

		return $clue;
	}

	/**
	 * Checkout orders and charge a card process
	 * @return string(Json)
	 */
	public function checkout() {
		if (!empty($this->request->post['offsite_provider'])) {
			$this->load->library('omise');
			
			$this->load->model('extension/payment/omise');
			$this->load->model('checkout/order');

			// Get Omise configuration.
			$omise = array();
			if ($this->config->get('omise_test_mode')) {
				$omise['pkey'] = $this->config->get('omise_pkey_test');
				$omise['skey'] = $this->config->get('omise_skey_test');
			} else {
				$omise['pkey'] = $this->config->get('omise_pkey');
				$omise['skey'] = $this->config->get('omise_skey');
			}

			// Create a order history with `Processing` status
			$order_id    = $this->session->data['order_id'];
			$order_info  = $this->model_checkout_order->getOrder($order_id);
			$order_total = $this->currency->format($order_info['total'], $order_info['currency_code'], '', false);
			if ($order_info) {
				try {
					// Try to create an offsite charge.
					$omise_charge = OmiseCharge::create(
						array(
							"amount"      => OmisePluginHelperCharge::amount($order_info['currency_code'], $order_total),
							"currency"    =>$this->config->get('config_currency'),
							"description" => $this->request->post['description'],
							"return_uri"  => $this->url->link('extension/payment/omise/checkoutcallback&order_id='.$order_id, '', 'SSL'),
							"offsite"     => $this->request->post['offsite_provider']
						),
						$omise['pkey'],
						$omise['skey']
					);

					// Status: failed.
					if ($omise_charge['failure_code'] || $omise_charge['failure_code']) {
						throw new Exception($omise_charge['failure_code'].': '.$omise_charge['failure_code'], 1);
					}

					$this->model_extension_payment_omise->addChargeTransaction($order_id, $omise_charge['id']);

					// Status: processing.
					$this->model_checkout_order->addOrderHistory($order_id, 2);

					echo json_encode(array(
						'omise'    => $omise_charge,
						'captured' => $omise_charge['captured'],
						'redirect' => $omise_charge['authorize_uri']
					));
				} catch (Exception $e) {
					// Status: failed.
					$error_message = $this->searchErrorTranslation('Payment ' . $e->getMessage());

					$this->model_checkout_order->addOrderHistory($order_id, 10, $error_message);
					echo json_encode(array(
						'error' => $error_message
					));
				}
			} else {
				echo json_encode(array('error' => 'Cannot find your order, please try again.'));
			}
		} else {
			echo json_encode(array('error' => 'Please select a bank from the list.'));
		}
	}

	/**
	 * Omise internet banking form
	 * @return void
	 */
	public function index() {
		$this->load->model('checkout/order');
		$this->load->language('extension/payment/omise');
		$this->load->language('extension/payment/omise_offsite');

		$data = array();

		// Retrieve order information
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if ($order_info) {
			$data = array_merge($data, array(
				'button_confirm'   => $this->language->get('button_confirm'),
				'checkout_url'     => $this->url->link('extension/payment/omise_offsite/checkout', '', 'SSL'),
				'success_url'      => $this->url->link('checkout/success', '', 'SSL'),
				'text_config_one'  => trim($this->config->get('text_config_one')),
				'text_config_two'  => trim($this->config->get('text_config_two')),
				'orderid'          => date('His') . $this->session->data['order_id'],
				'orderdate'        => date('YmdHis'),
				'currency'         => $order_info['currency_code'],
				'orderamount'      => $this->currency->format($order_info['total'], $order_info['currency_code'] , false, false),
				'billemail'        => $order_info['email'],
				'billphone'        => html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8'),
				'billaddress'      => html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8'),
				'billcountry'      => html_entity_decode($order_info['payment_iso_code_2'], ENT_QUOTES, 'UTF-8'),
				'billprovince'     => html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8'),
				'billcity'         => html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8'),
				'billpost'         => html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8'),
				'deliveryname'     => html_entity_decode($order_info['shipping_firstname'] . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8'),
				'deliveryaddress'  => html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8'),
				'deliverycity'     => html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8'),
				'deliverycountry'  => html_entity_decode($order_info['shipping_iso_code_2'], ENT_QUOTES, 'UTF-8'),
				'deliveryprovince' => html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8'),
				'deliveryemail'    => $order_info['email'],
				'deliveryphone'    => html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8'),
				'deliverypost'     => html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8'),
				'payment_title'    => empty($this->config->get('omise_offsite_payment_title')) ? $this->language->get('text_title') : $this->config->get('omise_offsite_payment_title')
			));

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/payment/omise_offsite.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/extension/payment/omise_offsite.tpl', $data);
			} else {
				return $this->load->view('extension/payment/omise_offsite.tpl', $data);
			}
		}
	}
}