<?php
class ModelExtensionPaymentOmiseOffsite extends Model {
    public function getMethod($address, $total) {
        if ($this->config->get('omise_status') != 1) {
            return false;
        }

        $this->load->language('extension/payment/omise_offsite');

        if ($this->config->get('omise_offsite_payment_title') != "") {
            $payment_title = $this->config->get('omise_offsite_payment_title');
        } else {
            $payment_title = $this->language->get('text_title');
        }

        return array(
            'code'       => 'omise_offsite',
            'title'      => $payment_title,
            'terms'      => '',
            'sort_order' => $this->config->get('omise_offsite_sort_order')
        );
    }
}
