<?php

class ControllerPaymentOmise extends Controller
{
    /**
     * Public Key.
     *
     */
    private $_public_key;

    /**
     * Secret Key.
     *
     */
    private $_secret_key;

    /**
     *
     * @return void
     */
    private function _getOmiseKey()
    {
        // Get Omise configuration.
        $omise = $this->config->get('Omise');
        
        // If test mode is enable,
        // replace Omise public and secret key with test key.
        if ($omise['test_mode']) {
            $omise['public_key'] = $omise['public_key_test'];
            $omise['secret_key'] = $omise['secret_key_test'];
        }

        $this->_public_key = $omise['public_key'];
        $this->_secret_key = $omise['secret_key'];
    }

    public function success()
    {
        $this->load->model('checkout/order');

        $this->model_checkout_order->confirm($this->session->data['order_id'], 2);

        $this->redirect($this->url->link('checkout/success', 'token=' . $this->session->data['token'], 'SSL'));
    }
    /**
     * Checkout process
     *
     */
    public function checkout()
    {
        // Get Omise's Key that config from admin page.
        $this->_getOmiseKey();
        
        // If has a `post['omise_token']` request.
        if (isset($this->request->post['omise_token'])) {

            // Load `omise-php` library.
            $this->load->library('omise/omise-php/lib/Omise');

            try {
                // Try to create a charge and capture it.
                $omise_charge = OmiseCharge::create(
                    array(
                        "amount"        => 100025,
                        "currency"      => "thb",
                        "description"   => "Order-345678",
                        "card"          => $this->request->post['omise_token']
                    ),
                    $this->_public_key,
                    $this->_secret_key
                );
                echo json_encode(
                    array(
                        'failure_code'      => $omise_charge['failure_code'],
                        'failure_message'   => $omise_charge['failure_message'],
                        'captured'          => $omise_charge['captured'],
                    )
                );
            } catch (Exception $e) {
                echo json_encode(array('error' => $e->getMessage()));
            }
        } else {
            return 'not authorized';
        }
    }

    /**
     * Omise collec a customer's card form
     *
     */
    protected function index()
    {
        // Load language.
        $this->language->load('payment/omise');

        // Get Omise configuration.
        $omise = $this->config->get('Omise');
        
        // If test mode was enabled, replace Omise public and secret key with test key.
        if ($omise['test_mode']) {
            $omise['public_key'] = $omise['public_key_test'];
            $omise['secret_key'] = $omise['secret_key_test'];
        }

        $this->data['button_confirm']   = $this->language->get('button_confirm');
        $this->data['checkout_url']     = $this->url->link('payment/omise/checkout', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['success_url']      = $this->url->link('payment/omise/success', 'token=' . $this->session->data['token'], 'SSL');

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
            
            $this->data['omise']                = $omise;

            if (file_exists(DIR_TEMPLATE.$this->config->get('config_template') . '/template/payment/omise.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/omise.tpl';
            } else {
                $this->template = 'default/template/payment/omise.tpl';
            }
            
            $this->render();
        }
    }

    public function callback()
    {
        if (isset($this->request->post['orderid'])) {
            $order_id = trim(substr(($this->request->post['orderid']), 6));
        } else {
            die('Illegal Access');
        }
      
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
      
        if ($order_info) {
            $data = array_merge($this->request->post,$this->request->get);
      
            //payment was made successfully
            if ($data['status'] == 'Y' || $data['status'] == 'y') {
                // update the order status accordingly
            }
        }
    }
}