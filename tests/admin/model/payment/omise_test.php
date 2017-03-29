<?php
require_once(__DIR__.'/../../../../src/admin/model/payment/omise.php');

class ModelPaymentOmiseTest extends PHPUnit_Framework_TestCase {
    public function setup() {
        $this->registry = new MockRegistry('admin');
        $this->model = new ModelPaymentOmise($this->registry);
    }

    public function tearDown() {
    }

    public function testInstallSuccess() {
        $model_setting_setting = $this->registry->mockModel('setting/setting', array('editSetting'), array($this->registry));
        $model_setting_setting->expects($this->once())
            ->method('editSetting')
            ->with('omise');

        $this->model->install();
    }

    public function testGetOmiseAccount() {
        $account = $this->model->getOmiseAccount();
        print_r($account);
    }
}