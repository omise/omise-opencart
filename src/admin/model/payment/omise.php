<?php

class ModelPaymentOmise extends Model
{
    /**
     * Install a table called [prefix]omise_gateway
     * for use in Omise Payment Gateway module.
     *
     * @return void
     */
    public function install()
    {
        // Create new table
        $this->db->query("CREATE TABLE `" .DB_PREFIX. "omise_gateway` (
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
    }

    /**
     * Drop [prefix]omise_gateway table when uninstall Omise Payment Gateway module.
     *
     * @return void
     */
    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "omise_gateway`;");
    }

    /**
     * Get config from [prefix]omise_gateway table.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->db->query("SELECT * FROM `" . DB_PREFIX . "omise_gateway` WHERE `id` = 1")->row;
    }

    /**
     * Update config value.
     *
     * @return void
     */
    public function updateConfig($update)
    {
        $string = "";

        foreach ($update as $key => $value)
            $string .= "`".$key."` = '".$value."', ";

        $string = substr($string, 0, -2);

        $this->db->query("UPDATE " . DB_PREFIX .  "omise_gateway SET ".$string." WHERE id = 1");
    }
}
?>
