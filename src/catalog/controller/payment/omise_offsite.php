<?php

class ControllerPaymentOmiseOffsite extends Controller {
    /**
     * Checkout orders and charge a card process
     *
     * @return string(Json)
     */
    public function checkout() {
        // Define 'OMISE_USER_AGENT_SUFFIX'
        if(!defined('OMISE_USER_AGENT_SUFFIX') && defined('VERSION')) {
            define('OMISE_USER_AGENT_SUFFIX', 'OmiseOpenCart/1.4 OpenCart/' . VERSION);
        }

        // Define 'OMISE_API_VERSION'
        if(!defined('OMISE_API_VERSION')) {
            define('OMISE_API_VERSION', '2014-07-27');
        }

        // If has a `post['omise_token']` request.
        if (!empty($this->request->post['offsite_provider'])) {
            $this->load->helper('omise_currency');

            // Load `omise-php` library.
            $this->load->library('omise/omise-php/lib/Omise');

            // Get Omise configuration.
            $omise = $this->config->get('Omise');

            // If test mode was enabled,
            // replace Omise live key with test key.
            if (isset($omise['test_mode']) && $omise['test_mode']) {
                $omise['public_key'] = $omise['public_key_test'];
                $omise['secret_key'] = $omise['secret_key_test'];
            }

            // Create a order history with `Processing` status
            $this->load->model('checkout/order');
            $this->load->model('payment/omise');

            $order_id    = $this->session->data['order_id'];
            $order_info  = $this->model_checkout_order->getOrder($order_id);
            $order_total = $this->currency->format(
                $order_info['total'],
                $order_info['currency_code'],
                $order_info['currency_value'],
                false
            );

            if ($order_info) {
                try {
                    // Try to create a charge and capture it.
                    $omise_charge = OmiseCharge::create(
                        array(
                            'amount'      => formatChargeAmount($order_info['currency_code'], $order_total),
                            'currency'    => $order_info['currency_code'],
                            'description' => $this->request->post['description'],
                            'return_uri'  => $this->url->link('payment/omise/checkoutcallback&order_id='.$order_id, '', 'SSL'),
                            'offsite'     => $this->request->post['offsite_provider']
                        ),
                        $omise['public_key'],
                        $omise['secret_key']
                    );

                    if (is_null($omise_charge['failure_code']) && is_null($omise_charge['failure_code'])) {
                        // Status: processing.
                        $this->model_payment_omise->addChargeTransaction($order_id, $omise_charge['id']);
                        $this->model_checkout_order->update($order_id, 2);
                    } else {
                        // Status: failed.
                        $this->model_checkout_order->update($order_id, 10);
                    }

                    echo json_encode(
                        array(
                            'failure_code'    => $omise_charge['failure_code'],
                            'failure_message' => $omise_charge['failure_message'],
                            'captured'        => $omise_charge['captured'],
                            'omise'           => $omise_charge,
                            'redirect'        => $omise_charge['authorize_uri']
                        )
                    );
                } catch (Exception $e) {
                    // Status: failed.
                    $this->model_checkout_order->update($this->session->data['order_id'], 10);
                    echo json_encode(array('error' => $e->getMessage()));
                }
            } else {
                echo json_encode(array('error' => 'Cannot find your order, please try again.'));
            }
        } else {
            echo json_encode(array('error' => 'Please select one provider from the list.'));
        }
    }
    
    /**
     * Omise card information form
     *
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

        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['checkout_url']   = $this->url->link('payment/omise_offsite/checkout', '', 'SSL');
        $this->data['success_url']    = $this->url->link('checkout/success', '', 'SSL');

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) {
            $this->data['text_config_one']  = trim($this->config->get('text_config_one'));
            $this->data['text_config_two']  = trim($this->config->get('text_config_two'));
            $this->data['orderid']          = date('His') . $this->session->data['order_id'];
            $this->data['callbackurl']      = $this->url->link('payment/custom/callback', '', 'SSL');
            $this->data['orderdate']        = date('YmdHis');
            $this->data['currency']         = $order_info['currency_code'];
            $this->data['orderamount']      = $this->currency->format($order_info['total'], $this->data['currency'], false, false);
            $this->data['billemail']        = $order_info['email'];
            $this->data['billphone']        = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $this->data['billaddress']      = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
            $this->data['billcountry']      = html_entity_decode($order_info['payment_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $this->data['billprovince']     = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');;
            $this->data['billcity']         = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $this->data['billpost']         = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryname']     = html_entity_decode($order_info['shipping_firstname'] . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryaddress']  = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverycity']     = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverycountry']  = html_entity_decode($order_info['shipping_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryprovince'] = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
            $this->data['deliveryemail']    = $order_info['email'];
            $this->data['deliveryphone']    = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $this->data['deliverypost']     = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/omise_offsite.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/omise_offsite.tpl';
            } else {
                $this->template = 'default/template/payment/omise_offsite.tpl';
            }

            $this->render();
        }
    }
}