<?php

class ModelPaymentOmise extends Model
{
    public function getMethod($address, $total) {
        $this->load->language('payment/omise');
     
        $method_data = array(   'code'          => 'omise',
                                'title'         => $this->language->get('text_title'),
                                'sort_order'    => $this->config->get('custom_sort_order'));
     
       return $method_data;
     }    

     public function addChargeTransaction($order_id, $charge_id) {
         $this->db->query(
             "INSERT INTO `" . DB_PREFIX . "omise_charge` " .
             "SET order_id = '" . $this->db->escape($order_id) . "', " . 
             "omise_charge_id = '" . $this->db->escape($charge_id) . "', " .
             "date_added = NOW()");
     }

     public function getChargeTransaction($order_id) {
         return $this->db->query(
             "SELECT * " .
             "FROM `" . DB_PREFIX . "omise_charge` " .
             "WHERE order_id = '" . $this->db->escape($order_id) . "'");
     }
}