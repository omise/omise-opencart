<?php

class ControllerPaymentOmiseOffsite extends Controller {
    /**
     * $error
     *
     */
    private $error = array();

    /**
     * Render Omise Payment Gateway - Internet Banking extension setting page
     *
     * @return void
     */
    public function index() {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load model.
        $this->load->model('setting/setting');

        // Load language.
        $this->language->load('payment/omise');
        $this->language->load('payment/omise_offsite');


        /**
         * POST Request handle.
         *
         */
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if ($this->request->post['omise_offsite_status'] == 1 && $this->config->get('omise_status') != 1) {
                $this->session->data['error'] = $this->language->get('error_need_omise_extension');
                $this->data['input_error']['omise_offsite_status'] = $this->language->get('error_need_omise_extension');
            } else {
                $this->model_setting_setting->editSetting('omise_offsite', $this->request->post);
                $this->data['input_error'] = array();
                $this->data = array_merge($this->data, $this->request->post);

                $this->session->data['success'] = $this->language->get('text_session_save');
                $this->redirect($this->url->link('payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }


        /**
         * Language setup.
         *
         */
        $this->document->setTitle('Omise Payment Gateway Internet Banking Configuration');

        // Set form label with language.
        $this->data['heading_title']                    = $this->language->get('heading_title');
        $this->data['button_save']                      = $this->language->get('text_button_save');
        $this->data['button_cancel']                    = $this->language->get('text_button_cancel');
        $this->data['entry_order_status']               = $this->language->get('entry_order_status');
        $this->data['text_enabled']                     = $this->language->get('text_enabled');
        $this->data['text_disabled']                    = $this->language->get('text_disabled');
        $this->data['entry_status']                     = $this->language->get('entry_status');

        // Set action button.
        $this->data['action']                           = $this->url->link('payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel']                           = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');


        /**
         * Page data setup.
         *
         */
        $this->data['omise_offsite_status'] = $this->config->get('omise_offsite_status');


        /**
         * Page setup.
         *
         */
        $this->_setBreadcrumb()
             ->_getSessionFlash();


        /**
         * Template setup.
         *
         */
        // Set template.
        $this->template = 'payment/omise_offsite.tpl';

        // Include sub-template.
        $this->children = array('common/header',
                                'common/footer');

        // Render output.
        $this->response->setOutput($this->render());
    }

    /**
     * Set page breadcrumb
     *
     * @return self
     */
    private function _setBreadcrumb($current = null) {
        // Set Breadcrumbs.
        $this->data['breadcrumbs']      = array();

        $this->data['breadcrumbs'][]    = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_payment'),
            'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if (!is_null($current)) {
            $this->data['breadcrumbs'][] = $current;
        }

        return $this;
    }

    /**
     * Get session flash from session variable and unset it
     *
     * @return self
     */
    private function _getSessionFlash() {
        $this->data['success'] = '';
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        }

        $this->data['error'] = '';
        if (isset($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];

            unset($this->session->data['error']);
        }

        return $this;
    }

    /**
     * This method will fire when user click `install` button from `extension/payment` page
     *
     * @return void
     */
    public function install() {
        // Set `success` session if it completely done.
        $this->session->data['success'] = "Installed";
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page
     * Uninstall anything about Omise Payment Gateway module that installed.
     *
     * @return void
     */
    public function uninstall() {
    }
}