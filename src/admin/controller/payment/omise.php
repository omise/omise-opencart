<?php

class ControllerPaymentOmise extends Controller
{
    /**
     * $error
     *
     */
    private $error = array();

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        // Load model.
        $this->load->model('setting/setting');
        $this->load->model('payment/omise');

        // Load language.
        $this->language->load('payment/omise');

        // POST request handler.
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->model_setting_setting->editSetting('omise', $this->request->post);

            if (isset($this->request->post['Omise'])) {
                $update                 = $this->request->post['Omise'];
                $update['test_mode']    = isset($update['test_mode']) ? 1 : 0;

                $this->model_payment_omise->updateConfig($update);

                foreach ($update as $key => $value)
                    $this->data[$key] = $value;

                // Set error.
                $this->data['input_error']          = array();
            }

            $this->session->data['success'] = $this->language->get('text_session_save');
            $this->redirect($this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'));
        }

        // Page initial.
        $this->_setPageLabel()
             ->_setBreadcrumb()
             ->_getSessionFlash();

        // Set data.
        $this->data['omise_status'] = $this->config->get('omise_status');

        $omise_config = $this->model_payment_omise->getConfig();
        foreach ($omise_config as $key => $value)
            $this->data[$key] = $value;

        // Set template.
        $this->template = 'payment/omise_setting.tpl';

        // Include sub-template.
        $this->children = array('common/header',
                                'common/footer');

        // Render output.
        $this->response->setOutput($this->render());
    }

    /**
     * Set page label
     *
     */
    private function _setPageLabel()
    {
        $this->document->setTitle('Omise Payment Gateway Configuration');

        // Set form label with language.
        $this->data['heading_title']                    = $this->language->get('heading_title');
        $this->data['entry_text_config_one']            = $this->language->get('text_config_one');
        $this->data['entry_text_config_two']            = $this->language->get('text_config_two');
        $this->data['button_save']                      = $this->language->get('text_button_save');
        $this->data['button_cancel']                    = $this->language->get('text_button_cancel');
        $this->data['entry_order_status']               = $this->language->get('entry_order_status');
        $this->data['text_enabled']                     = $this->language->get('text_enabled');
        $this->data['text_disabled']                    = $this->language->get('text_disabled');
        $this->data['entry_status']                     = $this->language->get('entry_status');

        // Set Omise setting label with language.
        $this->data['omise_key_test_public_label']      = $this->language->get('omise_key_test_public_label');
        $this->data['omise_key_test_secret_label']      = $this->language->get('omise_key_test_secret_label');
        $this->data['omise_test_mode_label']            = $this->language->get('omise_test_mode_label');
        $this->data['omise_key_public_label']           = $this->language->get('omise_key_public_label');
        $this->data['omise_key_secret_label']           = $this->language->get('omise_key_secret_label');

        // Set action button.
        $this->data['action']                           = $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel']                           = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        return $this;
    }

    /**
     * Set breadcrumb
     *
     */
    private function _setBreadcrumb()
    {
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
            'href'      => $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL'),             
            'separator' => ' :: '
        );

        return $this;
    }

    /**
     * $error
     *
     */
    private function _getSessionFlash()
    {
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
     * This method will fire when user click `install` button from `extension/payment` page.
     * It will call `model/payment/omise.php` file and run `install` method for installl something
     * that necessary to use in Omise Payment Gateway module. 
     *
     * @return void
     */
    public function install()
    {
        $this->load->model('payment/omise');
        $this->model_payment_omise->install();
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page.
     * Uninstall anything about Omise Payment Gateway module that installed.
     *
     */
    public function uninstall()
    {
        $this->load->model('payment/omise');
        $this->model_payment_omise->uninstall();   
    }
}