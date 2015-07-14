<?php
// Define 'OMISE_USER_AGENT_SUFFIX'
if(!defined('OMISE_USER_AGENT_SUFFIX') && defined('VERSION'))
    define('OMISE_USER_AGENT_SUFFIX', 'OmiseOpenCart/1.5.0.2 OpenCart/'.VERSION);

// Define 'OMISE_API_VERSION'
if(!defined('OMISE_API_VERSION'))
    define('OMISE_API_VERSION', '2014-07-27');

class ModelPaymentOmise extends Model
{
    /**
     * @var string  Omise table name
     */
    private $_table = 'omise_gateway';

    /**
     * Install a table that need to use in Omise Payment Gateway module
     * @return boolean
     */
    public function install()
    {
        try {
            // Create new table
            $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX.$this->_table."` (
                `id` int NOT NULL,
                `public_key` varchar(45),
                `secret_key` varchar(45),
                `public_key_test` varchar(45),
                `secret_key_test` varchar(45),
                `test_mode` tinyint NOT NULL DEFAULT 0,
                PRIMARY KEY `id` (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");

            // Insert seed data into table.
            $this->db->query("INSERT INTO `" .DB_PREFIX. "omise_gateway` 
                (`id`, `public_key`, `secret_key`, `public_key_test`, `secret_key_test`, `test_mode`)
                VALUES (1, '', '', '', '', 0)");

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Drop table when uninstall Omise Payment Gateway module
     * @return boolean
     */
    public function uninstall()
    {
        try {
            $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX.$this->_table."`;");
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Get config from table
     * @return array|boolean
     */
    public function getConfig()
    {
        try {
            return $this->db->query("SELECT * FROM `".DB_PREFIX.$this->_table."` WHERE `id` = 1")->row;
        } catch (Exception $e) {
            return false;            
        }
    }

    /**
     * Update config value
     * @return boolean
     */
    public function updateConfig($update)
    {
        try {
            $string = "";

            foreach ($update as $key => $value)
                $string .= "`".$key."` = '".$value."', ";

            $string = substr($string, 0, -2);

            $this->db->query("UPDATE ".DB_PREFIX.$this->_table." SET ".$string." WHERE id = 1");
        } catch (Exception $e) {
            return false;            
        }
    }

    /**
     * Get Omise keys from table that set in Omise setting page
     * @return array
     */
    private function _getOmiseKeys()
    {
        $omise = array();

        if ($this->config->get('omise_status')) {
            
            $omise['public_key']    = $this->config->get('omise_public_key');
            $omise['secret_key']    = $this->config->get('omise_secret_key');
            $omise['test_mode']     = $this->config->get('omise_test_mode');
            // If test mode was enabled, replace Omise public and secret key with test key.
            if (isset($omise['test_mode']) && $omise['test_mode']) {
                $omise['public_key'] = $this->config->get('omise_public_key_test');
                $omise['secret_key'] = $this->config->get('omise_secret_key_test');
            }
        }

        return $omise;
    }

    /**
     * Retrieve account from Omise server
     * @return OmiseAccount|array
     */
    public function getOmiseAccount()
    {
        // Load `omise-php` library.
        $this->load->library('omise/omise-php/lib/Omise');

        // Load language.
        $this->language->load('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_getOmiseKeys()) {
            try {
                $omise = OmiseAccount::retrieve($keys['public_key'], $keys['secret_key']);

                return $omise;
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
    public function getOmiseBalance()
    {
        // Load `omise-php` library.
        $this->load->library('omise/omise-php/lib/Omise');

        // Load language.
        $this->language->load('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_getOmiseKeys()) {
            try {
                $omise = OmiseBalance::retrieve($keys['public_key'], $keys['secret_key']);

                return $omise;
            } catch (Exception $e) {
                return array('error' => $e->getMessage());
            }
        } else {
            return $this->_error($this->language->get('error_extension_disabled'));
        }
    }

    /**
     * Get transaction list from Omise server
     * @return OmiseTransaction|array
     */
    public function getOmiseTransactionList()
    {
        // Load `omise-php` library.
        $this->load->library('omise/omise-php/lib/Omise');

        // Load language.
        $this->language->load('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_getOmiseKeys()) {
            try {
                $omise = OmiseTransaction::retrieve('', $keys['public_key'], $keys['secret_key']);

                return $omise;
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
    public function getOmiseTransferList()
    {
        // Load `omise-php` library.
        $this->load->library('omise/omise-php/lib/Omise');

        // Load language.
        $this->language->load('payment/omise');

        // Get Omise Keys.
        if ($keys = $this->_getOmiseKeys()) {
            try {
                $omise = OmiseTransfer::retrieve('', $keys['public_key'], $keys['secret_key']);

                return $omise;
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
    public function createOmiseTransfer($amount)
    {
        // Load `omise-php` library.
        $this->load->library('omise/omise-php/lib/Omise');

        // Load language.
        $this->language->load('payment/omise');
        
        // Get Omise Keys.
        if ($keys = $this->_getOmiseKeys()) {
            try {
                $omise = OmiseTransfer::create(array('amount' => $amount), $keys['public_key'], $keys['secret_key']);

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
     * Return error array template
     * @return array
     */
    private function _error($msg = '')
    {
        return array('error' => $msg);
    }
}
?>
