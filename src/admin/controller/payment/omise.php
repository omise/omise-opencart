<?php
class ControllerPaymentOmise extends Controller {
    /**
     * $error
     */
    private $error = array();

    /**
     * This method will fire when user click `install` button from `extension/payment` page
     * It will call `model/payment/omise.php` file and run `install` method for installl something
     * that necessary to use in Omise Payment Gateway module
     * @return void
     */
    public function install() {
        $this->load->model('payment/omise');

        try {
            // Install the extension
            if (!$this->model_payment_omise->install())
                throw new Exception('', 1);
        } catch (Exception $e) {
            // Uninstall
            $this->load->controller('extension/payment/uninstall');
        }
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page
     * Uninstall anything about Omise Payment Gateway module that installed.
     * @return void
     */
    public function uninstall() {
        //
    }

    public function index() {
        $this->load->model('payment/omise');
        $this->load->model('setting/setting');
        $this->load->model('localisation/currency');
        $this->load->language('payment/omise');
        $this->document->setTitle($this->language->get('heading_title'));
        
        $data = array();

        /**
         * POST Request handle.
         *
         */
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $update = $this->request->post;
            $update['omise_3ds'] = isset($update['omise_3ds']) ? $update['omise_3ds'] : 0;

            // Update
            $this->model_setting_setting->editSetting('omise', $update);

            $this->session->data['success'] = $this->language->get('text_session_save');
            $this->response->redirect($this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'));
        }

        // Setup error warning message
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // Setup success message
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        // Page data. Setting tab
        $data = array_merge($data, array(
            'omise_status'        => $this->config->get('omise_status'),
            'omise_test_mode'     => $this->config->get('omise_test_mode'),
            'omise_3ds'           => $this->config->get('omise_3ds'),
            'omise_pkey_test'     => $this->config->get('omise_pkey_test'),
            'omise_skey_test'     => $this->config->get('omise_skey_test'),
            'omise_pkey'          => $this->config->get('omise_pkey'),
            'omise_skey'          => $this->config->get('omise_skey'),
            'omise_payment_title' => $this->config->get('omise_payment_title')
        ));

        // Page data. Dashboard tab
        $data = array_merge($data, array(
            'omise_dashboard' => array(
                'error_warning' => '',
                'enabled'       => $this->config->get('omise_status')
            )
        ));

        if (!$data['omise_dashboard']['enabled']) {
            $data['omise_dashboard']['error_warning'][] = $this->language->get('error_extension_disabled');
        } else {
            try {
                // Retrieve Omise Account.
                $omise_account = $this->model_payment_omise->getOmiseAccount();
                if (isset($omise_account['error']))
                    throw new Exception('Omise Account:: '.$omise_account['error'], 1); 

                $data['omise_dashboard']['account']['email']     = $omise_account['email'];
                $data['omise_dashboard']['account']['created']   = $omise_account['created'];

                // Retrieve Omise Balance.
                $omise_balance = $this->model_payment_omise->getOmiseBalance();
                if (isset($omise_balance['error']))
                    throw new Exception('Omise Balance:: '.$omise_balance['error'], 1);

                $data['omise_dashboard']['balance']['livemode']  = $omise_balance['livemode'];
                $data['omise_dashboard']['balance']['available'] = $omise_balance['available'];
                $data['omise_dashboard']['balance']['total']     = $omise_balance['total'];
                $data['omise_dashboard']['balance']['currency']  = $omise_balance['currency'];

                // Retrieve Omise Charge List.
                $omise_charge = $this->model_payment_omise->getOmiseChargeList();
                if (isset($omise_charge['error']))
                    throw new Exception('Omise Charge:: '.$omise_charge['error'], 1);

                $data['omise_dashboard']['charge']['data']       = $omise_charge['data'];
                $data['omise_dashboard']['charge']['total']      = $omise_charge['total'];

                // Retrieve Omise Transfer List.
                $omise_transfer = $this->model_payment_omise->getOmiseTransferList();
                if (isset($omise_transfer['error']))
                    throw new Exception('Omise Transfer:: '.$omise_transfer['error'], 1);

                $data['omise_dashboard']['transfer']['data']     = $omise_transfer['data'];
                $data['omise_dashboard']['transfer']['total']    = $omise_transfer['total'];
            } catch (Exception $e) {
                $data['omise_dashboard']['error_warning'][] = $e->getMessage();
            }
        }

        // Check currency supported
        if (empty($this->model_localisation_currency->getCurrencyByCode('THB'))) {
            $data['omise_dashboard']['error_warning'][] = $this->language->get('error_currency_thb_not_found').' <a href="'.$this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL').'">Setup here</a>';
        }

        if (strtolower($this->config->get('config_currency')) !== 'thb') {
            $data['omise_dashboard']['error_warning'][] = $this->language->get('error_currency_no_support').' Your default currency is <strong>'.$this->config->get('config_currency').'</strong>.'.' <a href="'.$this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL').'">Setup here</a>';
        }

        // Page labels
        $data = array_merge($data, array(
            'heading_title'             => $this->language->get('heading_title'),
            'button_save'               => $this->language->get('button_save'),
            'action'                    => $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'),
            'button_cancel'             => $this->language->get('button_cancel'),
            'cancel'                    => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'text_form'                 => $this->language->get('text_form'),
            'entry_status'              => $this->language->get('entry_status'),
            'text_enabled'              => $this->language->get('text_enabled'),
            'text_disabled'             => $this->language->get('text_disabled'),
            'label_omise_pkey_test'     => $this->language->get('label_omise_pkey_test'),
            'label_omise_skey_test'     => $this->language->get('label_omise_skey_test'),
            'label_omise_pkey'          => $this->language->get('label_omise_pkey'),
            'label_omise_skey'          => $this->language->get('label_omise_skey'),
            'label_omise_mode_test'     => $this->language->get('label_omise_mode_test'),
            'label_omise_mode_live'     => $this->language->get('label_omise_mode_live'),
            'label_omise_3ds'           => $this->language->get('label_omise_3ds'),
            'label_omise_payment_title' => $this->language->get('label_omise_payment_title'),
            'transfer_url'              => $this->url->link('payment/omise/submittransfer', 'token=' . $this->session->data['token'], 'SSL'),
            'versioncheckup_url'        => $this->url->link('payment/omise/ajaxversioncheckup', 'token=' . $this->session->data['token'], 'SSL'),
        ));

        // Page templates
        $data = array_merge($data, array(
            'header'        => $this->load->controller('common/header'),
            'breadcrumbs'   => $this->_setBreadcrumb(null),
            'column_left'   => $this->load->controller('common/column_left'),
            'footer'        => $this->load->controller('common/footer')
        ));

        $this->response->setOutput($this->load->view('payment/omise.tpl', $data));
    }

    /**
     * Submit a `transfer` request to Omise server
     * @return void
     */
    public function submitTransfer() {
        $this->load->model('payment/omise');
        $this->load->language('payment/omise');

        try {
            // POST request handler.
            if (!$this->request->server['REQUEST_METHOD'] == 'POST')
                throw new Exception($this->language->get('error_needed_post_request'), 1);

            if (!isset($this->request->post['transfer_amount']))
                throw new Exception($this->language->get('error_need_amount_value'), 1);

            $transferring = $this->model_payment_omise->createOmiseTransfer($this->request->post['transfer_amount']);
            if (isset($transferring['error']))
                throw new Exception('Omise Transfer:: '.$transferring['error'], 1);
            else
                $this->session->data['success'] = $this->language->get('api_transfer_success');
        } catch (Exception $e) {
            $this->session->data['error'] = $e->getMessage();
        }
        
        $this->response->redirect($this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'));
    }

    /**
     * Set page breadcrumb
     * @return self
     */
    private function _setBreadcrumb($current = null) {
        $this->load->language('payment/omise');

        // Set Breadcrumbs.
        $breadcrumbs = array();

        $breadcrumbs[] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $breadcrumbs[] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $breadcrumbs[] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'),             
            'separator' => ' :: '
        );

        if (!is_null($current)) {
            $breadcrumbs[] = $current;
        }

        return $breadcrumbs;
    }

    /**
     * Get the latest version number of Omise-OpenCart from Github.
     * @return Json
     */
    public function ajaxVersionCheckup() {
        $this->load->library('omise');

        $ch = curl_init('https://api.github.com/repos/omise/omise-opencart/releases');
        curl_setopt_array($ch, array(
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_USERAGENT      => OMISE_USER_AGENT_SUFFIX
        ));

        try {
            // Make a request or thrown an exception.
            if(($result = curl_exec($ch)) === false) {
                $error = curl_error($ch);
                curl_close($ch);

                throw new Exception($error);
            }

            // Close.
            curl_close($ch);

            $current = strtotime(OMISE_OPENCART_RELEASED_DATE);
            $data    = null;
            $result  = json_decode($result);
            if (!empty($result)) {
                foreach ($result as $key => $value) {
                    if ($current < strtotime($value->created_at)) {
                        $current = strtotime($value->created_at);
                        $data = $value;
                    }
                }
            }

            echo json_encode(array(
                'status'          => 'connected',
                'has_update'      => strtotime(OMISE_OPENCART_RELEASED_DATE) != $current ? true : false,
                'released'        => $data,
                'current_version' => OMISE_OPENCART_VERSION
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'status'          => 'failed',
                'error_messsage'  => $e->getMessage()
            ));
        }
    }
}