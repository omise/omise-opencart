<?php
class ModelPaymentOmise extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/omise');

		if ($this->config->get('omise_payment_title') != "")
			$payment_title = $this->config->get('omise_payment_title');
		else
			$payment_title = $this->language->get('text_title');

		return array(
			'code'       => 'omise',
			'title'      => $payment_title,
			'terms'      => '',
			'sort_order' => $this->config->get('custom_sort_order')
		);
	}

	/**
	 * Get Omise keys from table that set in Omise setting page
	 * @return array
	 */
	public function retrieveOmiseKeys() {
		if ($this->config->get('omise_status') && $this->config->get('omise_test_mode')) {
			$keys = array(
				'pkey' => $this->config->get('omise_pkey_test'),
				'skey' => $this->config->get('omise_skey_test')
			);
		} else if ($this->config->get('omise_status')) {
			$keys = array(
				'pkey' => $this->config->get('omise_pkey'),
				'skey' => $this->config->get('omise_skey')
			);
		} else {
			$keys = array(
				'pkey' => '',
				'skey' => ''
			);
		}

		return $keys;
	}

	public function addChargeTransaction($order_id, $charge_id) {
		$this->db->query("INSERT into `" . DB_PREFIX . "omise_charge` SET order_id = '" . $order_id . "', omise_charge_id = '" . $charge_id . "', date_added = NOW()");
	}

	public function getChargeTransaction($order_id = null) {
		if ($order_id)
			return $this->db->query("SELECT * FROM `" . DB_PREFIX . "omise_charge` WHERE order_id = '" . (int)$order_id . "'");
		else
			return $this->db->query("SELECT * FROM `" . DB_PREFIX . "omise_charge`");
	}

	public function getOrderId($charge_id) {
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "omise_charge` WHERE omise_charge_id = '" . $charge_id. "'");
	}
}


