<?php

class ControllerPaymentOmise extends Controller
{
    /**
     * $error
     *
     */
    private $error = array();

    /**
     * Show Omise dashboard page
     *
     * @return void
     */
    public function dashboard()
    {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load model.
        $this->load->model('payment/omise');

        // Load language.
        $this->language->load('payment/omise');


        /**
         * Language setup.
         *
         */
        $this->document->setTitle($this->language->get('dashboard_page_title'));

        // Set page's component label with language.
        $this->data['heading_title']            = $this->language->get('dashboard_heading_title');
        $this->data['setting_url']              = $this->url->link('payment/omise', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['setting_button_title']     = $this->language->get('text_button_setting');
        $this->data['transfer_url']             = $this->url->link('payment/omise/submittransfer', 'token=' . $this->session->data['token'], 'SSL');


        /**
         * Page data setup.
         *
         */
        $this->data['omise'] = array();

        // Check Omise extension is enabled.
        if (!$this->config->get('omise_status')) {
            $this->session->data['error'] = $this->language->get('error_extension_disabled');
        } else {
            // Retrieve Omise Account.
            $omise_account = $this->model_payment_omise->getOmiseAccount();
            if (isset($omise_account['error']))
                $this->session->data['error'] = 'Omise Account:: '.$omise_account['error'];
            else {
                $this->data['omise']['account']['email']    = $omise_account['email'];
                $this->data['omise']['account']['created']  = $omise_account['created'];
            }

            // Retrieve Omise Balance.
            $omise_balance = $this->model_payment_omise->getOmiseBalance();
            if (isset($omise_balance['error']))
                $this->session->data['error'] = 'Omise Balance:: '.$omise_balance['error'];
            else {
                $this->data['omise']['balance']['livemode']     = $omise_balance['livemode'];
                $this->data['omise']['balance']['available']    = $omise_balance['available'];
                $this->data['omise']['balance']['total']        = $omise_balance['total'];
                $this->data['omise']['balance']['currency']     = $omise_balance['currency'];
            }

            // Retrieve Omise Transfer List.
            $omise_transfer = $this->model_payment_omise->getOmiseTransferList();
            if (isset($omise_transfer['error']))
                $this->session->data['error'] = 'Omise Transfer:: '.$omise_transfer['error'];
            else {
                $this->data['omise']['transfer']['data']        = array_reverse($omise_transfer['data']);
                $this->data['omise']['transfer']['total']       = $omise_transfer['total'];
            }
        }


        /**
         * Page setup.
         *
         */
        $this->_setBreadcrumb(array('text'      => $this->language->get('dashboard_breadcrumb_title'),
                                    'href'      => $this->url->link('payment/omise/dashboard', 'token=' . $this->session->data['token'], 'SSL'),             
                                    'separator' => ' :: '));

        $this->_getSessionFlash();

        $this->document->addScript(HTTP_SERVER.'/view/javascript/omise/omise-opencart-admin.js');


        /**
         * Template setup.
         *
         */
        // Set template.
        $this->template = 'payment/omise_dashboard.tpl';

        // Include sub-template.
        $this->children = array('common/header',
                                'common/footer');

        // Render output.
        $this->response->setOutput($this->render());
    }

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load model.
        $this->load->model('setting/setting');
        $this->load->model('payment/omise');

        // Load language.
        $this->language->load('payment/omise');


        /**
         * POST Request handle.
         *
         */
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


        /**
         * Page data setup.
         *
         */
        $this->data['omise_status'] = $this->config->get('omise_status');
        $omise_config = $this->model_payment_omise->getConfig();
        foreach ($omise_config as $key => $value)
            $this->data[$key] = $value;


        /**
         * Page setup.
         *
         */
        $this->_setPageLabel()
             ->_setBreadcrumb()
             ->_getSessionFlash();

        
        /**
         * Template setup.
         *
         */
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
    private function _setBreadcrumb($current = null)
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

        if (!is_null($current)) {
            $this->data['breadcrumbs'][] = $current;
        }

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
        try {
            /**
             * Prepare and loading necessary scripts.
             *
             */
            // Load model.
            $this->load->model('payment/omise');

            // Load language.
            $this->language->load('payment/omise');

            // Install Omise table.
            if (!$this->model_payment_omise->install())
                throw new Exception($this->language->get('error_omise_table_install_failed'), 1);
                
            // If done. Next, install vQmod library.
            // So, if it had vQmod in OpenCart project already,
            // just copy omise_menu.xml into vqmod/xml/ without installing again.
            if (file_exists(DIR_APPLICATION.'../vqmod')) {
                $file = DIR_APPLICATION.'../omise-opencart/vqmod/xml/omise_menu.xml';
                $dest = DIR_APPLICATION.'../vqmod/xml/';

                // Check file exists and writable.
                if (!file_exists($file))
                    throw new Exception($this->language->get('error_omise_menu_xml_not_exists'), 1);

                if (!file_exists($dest)) {
                    mkdir($dest, 0777);
                }

                if (!is_writable($dest))
                    throw new Exception($dest.' '.$this->language->get('error_file_not_writable'), 1);

                // Make a copy.
                if (!copy($file, $dest.'/omise_menu.xml')) 
                    throw new Exception($file.' - '.$dest.' '.$this->language->get('error_can_not_copy_file'), 1);
            } else {
                // If it had not, install it.
                $file = DIR_APPLICATION.'../omise-opencart/vqmod';
                $dest = DIR_APPLICATION.'..';

                // Check file exists and writable.
                if (!file_exists($file))
                    throw new Exception($this->language->get('error_vqmod_xml_not_exists'), 1);

                if (!is_writable($dest))
                    throw new Exception($dest.' '.$this->language->get('error_file_not_writable'), 1);

                // Make a copy.
                exec('cp -R '.$file.' '.$dest.' 2>&1', $output);
                if ($output)
                    throw new Exception($output[0], 1);

                // Make an install.
                include_once(DIR_APPLICATION.'../vqmod/install/omise-install.php');
                $installing = vQmodOmiseEditionInstall();
                if (isset($installing['error']))
                    throw new Exception($installing['error'], 1);

                if (!isset($installing['success']))
                    throw new Exception($this->language->get('error_somethung_wrong'), 1);
            }

            // Set `success` session if it completely done.
            $this->session->data['success'] = "Installed";
        } catch (Exception $e) {
            // Uninstall Omise extension if it failed to install.
            $this->load->model('setting/extension');
            $this->load->model('setting/setting');

            $this->model_setting_extension->uninstall('payment', 'omise');
            $this->model_setting_setting->deleteSetting('omise');

            $file = DIR_APPLICATION.'../vqmod/xml/omise_menu.xml';
            if (file_exists($file))
                unlink($file);

            $this->uninstall();

            $this->session->data['error'] = $e->getMessage();
        }
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page.
     * Uninstall anything about Omise Payment Gateway module that installed.
     *
     */
    public function uninstall()
    {
        $file = DIR_APPLICATION.'../vqmod/xml/omise_menu.xml';
        if (file_exists($file))
            unlink($file);

        $this->load->model('payment/omise');
        $this->model_payment_omise->uninstall();   
    }

    /**
     * Install vQmod library into OpenCart
     *
     * @return Json
     */
    public function installVQmod()
    {
        include_once(DIR_APPLICATION.'../vqmod/install/omise-install.php');

        $error     = array();
        $response   = array();

        try {
            $installing = vQmodOmiseEditionInstall();

            if (isset($installing['error']))
                $error['error'] = $installing['error'];

            if (isset($installing['success']))
                $error['msg'] = $installing['success'];

        } catch (Exception $e) {
            $error['error'] = $e->getMessage();
        }

        $response = array_merge($response, $error);

        echo json_encode($response);
    }

    public function submitTransfer()
    {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load model.
        $this->load->model('payment/omise');

        // Load language.
        $this->language->load('payment/omise');

        // POST request handler.
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if (isset($this->request->post['OmiseTransfer']['amount'])) {

                // var_dump($this->request->post['OmiseTransfer']['amount']); exit;
                $transferring = $this->model_payment_omise->createOmiseTransfer($this->request->post['OmiseTransfer']['amount']);
                if (isset($transferring['error']))
                    $this->session->data['error'] = 'Omise Transfer:: '.$transferring['error'];
                else {
                    $this->session->data['success'] = 'Sent your transfer request already, please waiting for comfirmation from the bank.';
                }
            } else {
                $this->session->data['error'] = 'Please submit your amount yo want to transfer.';
            }
        } else {
            $this->session->data['error'] = 'Wrong to request to transfer your amount.';
        }
        
        $this->redirect($this->url->link('payment/omise/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
    }
}