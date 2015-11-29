<?php
class ModelPaymentOmise extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/omise');

		return array(
			'code'       => 'omise',
			'title'      => $this->language->get('text_title'),
			'terms'      => '',
			'sort_order' => $this->config->get('custom_sort_order')
		);
	}
}