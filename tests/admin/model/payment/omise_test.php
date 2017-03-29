<?php
if (!defined('DB_PREFIX')) {
    define('DB_PREFIX', 'ocu_');
}
require_once(__DIR__.'/../model.php');
require_once(__DIR__.'/../../../../src/admin/model/payment/omise.php');

class ModelPaymentOmiseTest extends PHPUnit_Framework_TestCase {
    public function setup() {
        $this->model = new ModelPaymentOmise();
        $this->model->_admin = true;
    }

    public function tearDown() {
    }

    public function testInstallSuccess() {
        $model_setting_setting = $this->model->mockModel('setting/setting', array('editSetting'));
        $model_setting_setting->expects($this->once())
            ->method('editSetting')
            ->with('omise');

        $this->model->install();
    }
}