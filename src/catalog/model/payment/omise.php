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
}