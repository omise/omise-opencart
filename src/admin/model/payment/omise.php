<?php
class ModelPaymentOmise extends Model {
    /**
     * @var string  Omise table name
     */
    private $_table = 'omise_gateway';
    private $_group = 'omise';

    /**
     * Install a table that need to use in Omise Payment Gateway module
     * @return boolean
     */
    public function install() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting($this->_group, array(
            'omise_status'        => 0,
            'omise_pkey'          => '',
            'omise_skey'          => '',
            'omise_pkey_test'     => '',
            'omise_skey_test'     => '',
            'omise_test_mode'     => 0,
            'omise_3ds'           => 0,
            'omise_payment_title' => 'Credit Card (Powered by Omise)'
        ));

        /* Install omise_charge table */
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "omise_charge` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `order_id` INT(11) NOT NULL,
              `omise_charge_id` CHAR(45) NOT NULL,
              `date_added` DATETIME NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");

        /* Install omise_customer table */
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "omise_customer` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `customer_id` INT(11) NOT NULL,
              `omise_customer_id` CHAR(45) NOT NULL,
              `date_added` DATETIME NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");

        return true;
    }

    /**
     * Drop table when uninstall Omise Payment Gateway module
     * @return boolean
     */
    public function uninstall() {
        // ...
    }

    /**
     * Get config from table
     * @return array|boolean
     */
    public function getConfig() {
        try {
            $this->load->model('setting/setting');
            $this->model_setting_setting->getSetting($this->_group);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retrieve account from Omise server
     * @return OmiseAccount|array
     */
    public function getOmiseAccount() {
        $this->load->library('omise');
        $this->load->library('omise-php/lib/Omise');
        $this->load->language('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_retrieveOmiseKeys()) {
            try {
                return OmiseAccount::retrieve($keys['pkey'], $keys['skey']);
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Retrieve balance from Omise server
     * @return OmiseBalance|array
     */
    public function getOmiseBalance() {
        $this->load->library('omise');
        $this->load->library('omise-php/lib/Omise');
        $this->load->language('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_retrieveOmiseKeys()) {
            try {
                return OmiseBalance::retrieve($keys['pkey'], $keys['skey']);
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Get charge list from Omise server
     * @return OmiseCharge|array
     */
    public function getOmiseChargeList() {
        $this->load->library('omise');
        $this->load->library('omise-php/lib/Omise');
        $this->load->language('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_retrieveOmiseKeys()) {
            try {
                return OmiseCharge::retrieve('?limit=20&order=reverse_chronological', $keys['pkey'], $keys['skey']);
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Get transfer list from Omise server
     * @return OmiseTransfer|array
     */
    public function getOmiseTransferList() {
        $this->load->library('omise');
        $this->load->library('omise-php/lib/Omise');
        $this->load->language('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_retrieveOmiseKeys()) {
            try {
                return OmiseTransfer::retrieve('?limit=20&order=reverse_chronological', $keys['pkey'], $keys['skey']);
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Create a transfer to Omise server
     * @return OmiseTransfer|array
     */
    public function createOmiseTransfer($amount) {
        $this->load->library('omise');
        $this->load->library('omise-php/lib/Omise');
        $this->load->language('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_retrieveOmiseKeys()) {
            try {
                $omise = OmiseTransfer::create(array('amount' => $amount), $keys['pkey'], $keys['skey']);

                if (isset($omise['object']) && $omise['object'] == "transfer")
                    return true;
                else
                    return array('error' => 'Something went wrong.');
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Get Omise keys from table that set in Omise setting page
     * @return array
     */
    private function _retrieveOmiseKeys() {
        if ($this->config->get('omise_status') && $this->config->get('omise_test_mode')) {
            $keys = array(
                'pkey' => $this->config->get('omise_pkey_test'),
                'skey' => $this->config->get('omise_skey_test')
            );
        } else if ($this->config->get('omise_status')) {
            $keys = array(
                'pkey' => $this->config->get('omise_pkey'),
                'skey' => $this->config->get('omise_skey')
            );
        } else {
            $keys = array(
                'pkey' => '',
                'skey' => ''
            );
        }

        return $keys;
    }
}