<?php
class ControllerExtensionPaymentOmiseOffsite extends Controller
{
    /**
     * @var array
     */
    private $error = array();

    /**
     * @return string
     */
    private function flashSuccessMessages()
    {
        if (isset($this->session->data['success'])) {
            $msg = $this->session->data['success'];
            unset($this->session->data['success']);

            return $msg;
        }

        return "";
    }

    /**
     * @return string
     */
    private function flashErrorMessages()
    {
        if (isset($this->session->data['error'])) {
            $msg = $this->session->data['error'];
            unset($this->session->data['error']);

            return $msg;
        }

        return "";
    }

    /**
     * Set page breadcrumb
     * @return array
     */
    private function setBreadcrumb($current = null)
    {
        $this->load->language('extension/payment/omise_offsite');

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
            'href'      => $this->url->link('extension/payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if (! is_null($current)) {
            $breadcrumbs[] = $current;
        }

        return $breadcrumbs;
    }
 
    /**
     * @return array
     */
    private function pageDataSettingTab()
    {
        return array(
            'omise_offsite_status'        => $this->config->get('omise_offsite_status'),
            'omise_offsite_payment_title' => $this->config->get('omise_offsite_payment_title')
        );
    }

    /**
     * @return array
     */
    private function pageTranslation()
    {
        $this->load->language('extension/payment/omise_offsite');

        return array(
            'heading_title'                     => $this->language->get('heading_title'),
            'label_setting_module_config'       => $this->language->get('label_setting_module_config'),
            'label_setting_module_status'       => $this->language->get('label_setting_module_status'),
            'label_omise_offsite_payment_title' => $this->language->get('label_omise_offsite_payment_title'),
            'text_enabled'                      => $this->language->get('text_enabled'),
            'text_disabled'                     => $this->language->get('text_disabled'),
            'button_save'                       => $this->language->get('button_save'),
            'button_cancel'                     => $this->language->get('button_cancel'),
        );
    }

    /**
     * @return string
     */
    private function searchErrorTranslation($clue)
    {
        $this->load->language('extension/payment/omise_offsite');

        $translate_code = 'error_' . str_replace(' ', '_', strtolower($clue));
        $translate_msg  = $this->language->get($translate_code);

        if ($translate_code !== $translate_msg) {
            return $translate_msg;
        }

        return $clue;
    }

    /**
     * @return void
     */
    private function redirectTo($destination)
    {
        switch ($destination) {
            case 'omise_dashboard':
                $this->response->redirect($this->url->link('extension/payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'));
                break;

            default:
                $this->response->redirect($this->url->link('extension/payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'));
                break;
        }
    }

    public function action() {
        if (empty($this->request->get['order_id'])) {
            return;
        }

        $this->load->model('sale/order');
        $this->load->model('extension/payment/omise');

        $order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);

        if (empty($order_info)) {
            return;
        }

        $this->load->model('localisation/order_status');
        $this->load->language('extension/payment/omise_offsite_action');

        $data = array(
            'text_loading'   => $this->language->get('text_loading'),
            'button_refresh' => $this->language->get('button_refresh'),

            'order_id'        => $this->request->get['order_id'],
            'order_status_id' => $order_info['order_status_id'],
            'order_status'    => $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']),

            'token' => $this->session->data['token'],
        );
        return $this->load->view('extension/payment/omise_offsite_action.tpl', $data);
    }

    /**
     * This method will fire when user click `install` button from `extension/payment` page
     * It will call `model/payment/omise_offsite.php` file and run `install` method for installl stuff
     * that necessary to use in Omise Payment Gateway Internet Banking module
     * @return void
     */
    public function install()
    {
        $this->load->model('extension/payment/omise_offsite');

        try {
            // Install the extension
            if (! $this->model_extension_payment_omise_offsite->install()) {
                throw new Exception('', 1);
            }
        } catch (Exception $e) {
            // Uninstall
            $this->load->controller('extension/payment/uninstall');
        }
    }

    /**
     * This method will fire when user click `Uninstall` button from `extension/payment` page
     * Uninstall everything that related with Omise Payment Gateway module.
     * @return void
     */
    public function uninstall()
    {
    }

    /**
     * (GET) Page, route=payment/omise_offsite
     */
    public function index()
    {
        // POST Request handle
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->updateConfig();
        }

        $this->load->language('extension/payment/omise_offsite');
        $this->document->setTitle($this->language->get('heading_title'));

        // Manipulate page's data
        $data = array_merge(
            $this->pageDataSettingTab(),
            $this->pageTranslation(),
            array(
                'success'            => $this->flashSuccessMessages(),
                'error_warning'      => $this->flashErrorMessages(),
                'action'             => $this->url->link('extension/payment/omise_offsite', 'token=' . $this->session->data['token'], 'SSL'),
                'cancel'             => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            )
        );

        // Page templates
        $data = array_merge($data, array(
            'header'      => $this->load->controller('common/header'),
            'breadcrumbs' => $this->setBreadcrumb(null),
            'column_left' => $this->load->controller('common/column_left'),
            'footer'      => $this->load->controller('common/footer')
        ));

        $this->response->setOutput($this->load->view('extension/payment/omise_offsite.tpl', $data));
    }

    /**
     * (POST)
     * @return void
     */
    public function updateConfig()
    {
        $this->load->model('setting/setting');
        $this->load->language('extension/payment/omise_offsite');

        try {
            // Allowed only POST method
            if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
                throw new Exception($this->language->get('error_allowed_only_post_method'), 1);
            }

            $update = $this->request->post;
            if (! empty($update)) {
                if ($update['omise_offsite_status'] == 1 && $this->config->get('omise_status') != 1) {
                    throw new Exception($this->language->get('error_need_omise_extension'));
                }
                // Update
                $this->model_setting_setting->editSetting('omise_offsite', $update);
                $this->session->data['success'] = $this->language->get('text_session_save');
            }
        } catch (Exception $e) {
            $this->session->data['error'] = $this->searchErrorTranslation($e->getMessage());
        }

        $this->redirectTo('omise_offsite_setting');
    }
}
