<?php
class ModelExtensionPaymentOmiseOffsite extends Model {
    private $_group = 'omise_offsite';

    /**
     * Install a table that need to use in Omise Payment Gateway module
     * @return boolean
     */
    public function install()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting($this->_group, array(
            'omise_offsite_status'        => 0,
            'omise_offsite_payment_title' => 'Internet Banking (Powered by Omise)'
        ));

        return true;
    }

    /**
     * Drop table when uninstall Omise Payment Gateway module
     * @return boolean
     */
    public function uninstall()
    {
        // ...
    }

    /**
     * Get config from table
     * @return array|boolean
     */
    public function getConfig()
    {
        try {
            $this->load->model('setting/setting');
            $this->model_setting_setting->getSetting($this->_group);
        } catch (Exception $e) {
            return false;
        }
    }
}
