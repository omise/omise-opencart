<?php

class ControllerPaymentOmise extends Controller
{
    /**
     * Checkout orders and charge a card process
     * @return string(Json)
     */
    public function checkout()
    {
        $this->load->library('omise');

        // If has a `post['omise_token']` request.
        if (isset($this->request->post['omise_token'])) {
            // Load `omise-php` library.
            $this->load->library('omise-php/lib/Omise');

            // Get Omise configuration.
            $omise = array();
            if ($this->config->get('omise_test_mode')) {
                $omise['public_key'] = $this->config->get('omise_pkey_test');
                $omise['secret_key'] = $this->config->get('omise_skey_test');
            } else {
                $omise['public_key']    = $this->config->get('omise_pkey');
                $omise['secret_key']    = $this->config->get('omise_skey');
            }
            
            // Create a order history with `Processing` status
            $this->load->model('checkout/order');
            $order_id       = $this->session->data['order_id'];
            $order_info     = $this->model_checkout_order->getOrder($order_id);
            $order_total    = number_format($order_info['total'], 2, '', '');
            if ($order_info) {
                try {
                    // Try to create a charge and capture it.
                    $omise_charge = OmiseCharge::create(
                        array(
                            "amount"        => $order_total,
                            "currency"      => 'thb',
                            "description"   => $this->request->post['description'],
                            "card"          => $this->request->post['omise_token']
                        ),
                        $omise['public_key'],
                        $omise['secret_key']
                    );

                    if (is_null($omise_charge['failure_code']) && is_null($omise_charge['failure_code']) && $omise_charge['captured']) {
                        // Status: processed.
                        $this->model_checkout_order->addOrderHistory($order_id, 15);
                    } else {
                        // Status: failed.
                        $this->model_checkout_order->addOrderHistory($order_id, 10);
                    }

                    echo json_encode(
                        array(
                            'failure_code'      => $omise_charge['failure_code'],
                            'failure_message'   => $omise_charge['failure_message'],
                            'captured'          => $omise_charge['captured'],
                            'omise'             => $omise_charge
                        )
                    );
                } catch (Exception $e) {
                    // Status: failed.
                    $this->model_checkout_order->addOrderHistory($order_id, 10);
                    echo json_encode(array('error' => $e->getMessage()));
                }
            } else {
                echo json_encode(array('error' => 'Cannot find your order, please try again.'));
            }
        } else {
            return 'not authorized';
        }
    }

    /**
     * Retrieve list of months translation
     *
     * @return array
     */
    public function getMonths()
    {
        $months = array();
        for ($index=1; $index <= 12; $index++) {
            $month = ($index < 10) ? '0'.$index : $index;
            $months[$month] = $month;
        }
        return $months;
    }

    /**
     * Retrieve array of available years
     *
     * @return array
     */
    public function getYears()
    {
        $years = array();
        $first = date("Y");

        for ($index=0; $index <= 10; $index++) {
            $year = $first + $index;
            $years[$year] = $year;
        }
        return $years;
    }
    
    /**
     * Omise card information form
     * @return void
     */
    public function index()
    {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load language.
        $this->language->load('payment/omise');

        // Get Omise configuration.
        $omise = array();
        $omise['public_key']    = $this->config->get('omise_pkey');
        $omise['secret_key']    = $this->config->get('omise_skey');
        $omise['test_mode']     = $this->config->get('omise_test_mode');
        // If test mode was enabled, replace Omise public and secret key with test key.
        if (isset($omise['test_mode']) && $omise['test_mode']) {
            $omise['public_key'] = $this->config->get('omise_pkey_test');
            $omise['secret_key'] = $this->config->get('omise_skey_test');
        }

        $data['button_confirm']   = $this->language->get('button_confirm');
        $data['checkout_url']     = $this->url->link('payment/omise/checkout');
        $data['success_url']      = $this->url->link('checkout/success');

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) {
            $data['text_config_one']      = trim($this->config->get('text_config_one')); 
            $data['text_config_two']      = trim($this->config->get('text_config_two')); 
            $data['orderid']              = date('His') . $this->session->data['order_id'];
            $data['callbackurl']          = $this->url->link('payment/custom/callback');
            $data['orderdate']            = date('YmdHis');
            $data['currency']             = $order_info['currency_code'];
            $data['orderamount']          = $this->currency->format($order_info['total'], $data['currency'] , false, false);
            $data['billemail']            = $order_info['email'];
            $data['billphone']            = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $data['billaddress']          = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
            $data['billcountry']          = html_entity_decode($order_info['payment_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $data['billprovince']         = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');;
            $data['billcity']             = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $data['billpost']             = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $data['deliveryname']         = html_entity_decode($order_info['shipping_firstname'] . $order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
            $data['deliveryaddress']      = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8');
            $data['deliverycity']         = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
            $data['deliverycountry']      = html_entity_decode($order_info['shipping_iso_code_2'], ENT_QUOTES, 'UTF-8');
            $data['deliveryprovince']     = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');
            $data['deliveryemail']        = $order_info['email'];
            $data['deliveryphone']        = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
            $data['deliverypost']         = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');
            
            $data['omise']                = $omise;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/omise.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/payment/omise.tpl', $data);
            } else {
                return $this->load->view('default/template/payment/omise.tpl', $data);
            }
        }
    }
}