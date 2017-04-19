<?php
class ControllerPaymentOmiseOffsite extends Controller {
	/**
	 * Omise internet banking form
	 * @return void
	 */
	public function index() {
		$this->load->model('checkout/order');
		$this->load->language('payment/omise');
		$this->load->language('payment/omise_offsite');

		$data = array();

		// Retrieve order information
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if ($order_info) {
			$data = array_merge($data, array(
				'button_confirm'   => $this->language->get('button_confirm'),
				'checkout_url'     => $this->url->link('payment/omise_offsite/checkout'),
				'success_url'      => $this->url->link('checkout/success'),
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

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/omise_offsite.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/omise_offsite.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/omise_offsite.tpl', $data);
			}
		}
	}
}