<?php

class ControllerPaymentOmiseOffsite extends Controller {
    /**
     * Omise card information form
     * @return void
     */
    protected function index() {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load language.
        $this->language->load('payment/omise');
        $this->language->load('payment/omise_offsite');

        $this->data['button_confirm']   = $this->language->get('button_confirm');
        $this->data['checkout_url']     = $this->url->link('payment/omise_offsite/checkout');
        $this->data['success_url']      = $this->url->link('checkout/success');

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) {
            $this->data['text_config_one']      = trim($this->config->get('text_config_one'));
            $this->data['text_config_two']      = trim($this->config->get('text_config_two'));
            $this->data['orderid']              = date('His') . $this->session->data['order_id'];
            $this->data['callbackurl']          = $this->url->link('payment/custom/callback');
            $this->data['orderdate']            = date('YmdHis');
            $this->data['currency']             = $order_info['currency_code'];
            $this->data['orderamount']          = $this->currency->format($order_info['total'], $this->data['currency'] , false, false);
            $this->data['billemail']            = $order_info['email'];
            $this->data['billphone']            = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $this->data['billaddress']          = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
            $this->data['billcountry']          = html_entity_decode($order_info['payment_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $this->data['billprovince']         = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');;
            $this->data['billcity']             = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $this->data['billpost']             = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryname']         = html_entity_decode($order_info['shipping_firstname'] . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryaddress']      = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverycity']         = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverycountry']      = html_entity_decode($order_info['shipping_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryprovince']     = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryemail']        = $order_info['email'];
            $this->data['deliveryphone']        = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverypost']         = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');

            if (file_exists(DIR_TEMPLATE.$this->config->get('config_template') . '/template/payment/omise_offsite.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/omise_offsite.tpl';
            } else {
                $this->template = 'default/template/payment/omise_offsite.tpl';
            }

            $this->render();
        }
    }
}