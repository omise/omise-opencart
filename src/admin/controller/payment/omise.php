<?php

class ControllerPaymentOmise extends Controller
{
    /**
     * $error
     *
     */
    private $error = array();

    /**
     * Render Omise Payment Gateway dashboard page
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
            try {
                // Retrieve Omise Account.
                $omise_account = $this->model_payment_omise->getOmiseAccount();
                if (isset($omise_account['error']))
                    throw new Exception('Omise Account:: '.$omise_account['error'], 1);

                $this->data['omise']['account']['email']    = $omise_account['email'];
                $this->data['omise']['account']['created']  = $omise_account['created'];

                // Retrieve Omise Balance.
                $omise_balance = $this->model_payment_omise->getOmiseBalance();
                if (isset($omise_balance['error']))
                    throw new Exception('Omise Balance:: '.$omise_balance['error'], 1);

                $this->data['omise']['balance']['livemode']     = $omise_balance['livemode'];
                $this->data['omise']['balance']['available']    = $omise_balance['available'];
                $this->data['omise']['balance']['total']        = $omise_balance['total'];
                $this->data['omise']['balance']['currency']     = $omise_balance['currency'];

                // Retrieve Omise Transfer List.
                $omise_transfer = $this->model_payment_omise->getOmiseTransferList();
                if (isset($omise_transfer['error']))
                    throw new Exception('Omise Transfer:: '.$omise_transfer['error'], 1);

                $this->data['omise']['transfer']['data']        = array_reverse($omise_transfer['data']);
                $this->data['omise']['transfer']['total']       = $omise_transfer['total'];
            } catch (Exception $e) {
                $this->session->data['error'] = $e->getMessage();
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
     * Render Omise Payment Gateway extension setting page
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
         * Language setup.
         *
         */
        $this->document->setTitle('Omise Payment Gateway Configuration');

        // Set form label with language.
        $this->data['heading_title']                    = $this->language->get('heading_title');
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
        $this->_setBreadcrumb()
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
     * Set page breadcrumb
     * @return self
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
     * Get session flash from session variable and unset it
     * @return self
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
     * This method will fire when user click `install` button from `extension/payment` page
     * It will call `model/payment/omise.php` file and run `install` method for installl something
     * that necessary to use in Omise Payment Gateway module
     * @return void
     */
    public function install()
    {
        /**
         * Prepare and loading necessary scripts.
         *
         */
        // Load model.
        $this->load->model('payment/omise');

        // Load language.
        $this->language->load('payment/omise');

        try {
            // Create new table for contain Omise Keys.
            if (!$this->model_payment_omise->install())
                throw new Exception($this->language->get('error_omise_table_install_failed'), 1);
                
            // If done. Next, install vQmod library.
            // So, if it had vQmod in OpenCart project already,
            // just copy omise.xml into vqmod/xml/ without installing again.
            if (file_exists(DIR_APPLICATION.'../vqmod')) {
                $file = DIR_APPLICATION.'../omise-opencart/vqmod/xml/omise.xml';
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
                if (!copy($file, $dest.'/omise.xml')) 
                    throw new Exception($file.' '.$this->language->get('error_can_not_copy_file'), 1);
            } else {
                // If it had not, install it.
                $file   = DIR_APPLICATION.'../omise-opencart/vqmod';
                $dest   = DIR_APPLICATION.'..';
                $backup = DIR_APPLICATION.'../omise-opencart/backup';

                // Check file exists and writable.
                if (!file_exists($file))
                    throw new Exception($this->language->get('error_vqmod_xml_not_exists'), 1);

                if (!is_writable($dest))
                    throw new Exception($dest.' '.$this->language->get('error_file_not_writable'), 1);

                // Create 
                if (!file_exists($backup)) {
                    if (!mkdir($backup))
                        throw new Exception($backup.' '.$this->language->get('error_file_permission_denied'), 1);

                    mkdir($backup.'/admin');

                    $bak_catalog_index   = DIR_APPLICATION.'../index.php';
                    $bak_admin_index     = DIR_APPLICATION.'../admin/index.php';
                    // Make a copy catalog's index file.
                    if (!copy($bak_catalog_index, $backup.'/index.php')) 
                        throw new Exception($bak_catalog_index.' '.$this->language->get('error_can_not_copy_file'), 1);

                    if (!chmod($backup.'/index.php', 0755)) 
                        throw new Exception($bak_catalog_index.' '.$this->language->get('error_can_not_copy_file'), 1);

                    // Make a copy admin's index file.
                    if (!copy($bak_admin_index, $backup.'/admin/index.php')) 
                        throw new Exception($bak_admin_index.' '.$this->language->get('error_can_not_copy_file'), 1);

                    if (!chmod($backup.'/admin/index.php', 0755)) 
                        throw new Exception($bak_catalog_index.' '.$this->language->get('error_can_not_copy_file'), 1);
                }

                // Make a copy.
                $this->copyRecursively($file, $dest.'/vqmod');

                // Make an install.
                include_once(DIR_APPLICATION.'../vqmod/install/omise-install.php');
                $installing = vQmodOmiseEditionInstall();
                if (isset($installing['error'])) {
                    $this->rmdirRecursively(DIR_APPLICATION.'../vqmod');

                    throw new Exception($installing['error'], 1);
                }

                if (!isset($installing['success'])) {
                    $this->rmdirRecursively(DIR_APPLICATION.'../vqmod');
                    
                    throw new Exception('CODE [acpoL365]'.$this->language->get('error_general_error'), 1);
                }
            }

            // Set `success` session if it completely done.
            $this->session->data['success'] = "Installed";
        } catch (Exception $e) {
            // Uninstall Omise extension if it failed to install.
            $this->load->model('setting/extension');
            $this->load->model('setting/setting');

            $this->model_setting_extension->uninstall('payment', 'omise');
            $this->model_setting_setting->deleteSetting('omise');

            $file = DIR_APPLICATION.'../vqmod/xml/omise.xml';
            if (file_exists($file))
                unlink($file);

            $this->uninstall();

            $this->session->data['error'] = $e->getMessage();
        }
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page
     * Uninstall anything about Omise Payment Gateway module that installed.
     * @return void
     */
    public function uninstall()
    {
        $file = DIR_APPLICATION.'../vqmod/xml/omise.xml';
        if (file_exists($file))
            unlink($file);

        $this->load->model('payment/omise');
        $this->model_payment_omise->uninstall();;
    }

    /**
     * Submit a `transfer` request to Omise server
     * @return void
     */
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

        try {
            // POST request handler.
            if (!$this->request->server['REQUEST_METHOD'] == 'POST')
                throw new Exception($this->language->get('error_needed_post_request'), 1);

            if (!isset($this->request->post['OmiseTransfer']['amount']))
                throw new Exception($this->language->get('error_need_amount_value'), 1);

            $transferring = $this->model_payment_omise->createOmiseTransfer($this->request->post['OmiseTransfer']['amount']);
            if (isset($transferring['error']))
                throw new Exception('Omise Transfer:: '.$transferring['error'], 1);
            else
                $this->session->data['success'] = $this->language->get('api_transfer_success');
        } catch (Exception $e) {
            $this->session->data['error'] = $e->getMessage();
        }
        
        $this->redirect($this->url->link('payment/omise/dashboard', 'token=' . $this->session->data['token'], 'SSL'));
    }

    /**
     * This's a snippet code for recursively copy files
     * from one directory to another (used in `install` method only).
     * @param String $src       Source of files being moved
     * @param String $dest      Destination of files being moved
     * @return boolean|void
     */
    public function copyRecursively($src, $dest)
    {
        // If the destination directory does not exist create it
        if(!is_dir($dest)) { 
            if(!mkdir($dest)) {
                // If the destination directory could not be created stop processing
                return false;
            }    
        }

        // Open the source directory to read in files
        $i = new DirectoryIterator($src);
        foreach($i as $f) {
            if($f->isFile()) {
                copy($f->getRealPath(), "$dest/" . $f->getFilename());
            } else if(!$f->isDot() && $f->isDir()) {
                $this->copyRecursively($f->getRealPath(), "$dest/$f");
            }
        }
    }

    /**
     * This's a snippet code for recursively remove files (used in `install` method only).
     * @param String $dir  Directory that you need to remove
     * @return void|boolean
     */
    public function rmdirRecursively($dir)
    {
        try {
            if (is_dir($dir)) { 
                $objects = scandir($dir); 
                foreach ($objects as $object) { 
                    if ($object != "." && $object != "..") { 
                        if (filetype($dir."/".$object) == "dir") $this->rmdirRecursively($dir."/".$object); else unlink($dir."/".$object); 
                    } 
                } 
                reset($objects); 
                rmdir($dir); 
            }    
        } catch (Exception $e) {
            return false;            
        }
     }
}