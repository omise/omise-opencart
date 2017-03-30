<?php
use AspectMock\Test as test;

require_once(__DIR__.'/../../../../src/admin/model/payment/omise.php');

class ModelPaymentOmiseTest extends PHPUnit_Framework_TestCase {
    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp() {
        $this->registry = new MockRegistry('admin');
        $this->model = new ModelPaymentOmise($this->registry);
    }

    /**
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown() {
        test::clean();
    }

    public function testInstallSuccess() {
        $model_setting_setting = $this->registry->mockModel('setting/setting', array('editSetting'), array($this->registry));
        $model_setting_setting->expects($this->once())
            ->method('editSetting')
            ->with('omise');

        $this->model->install();
    }

    public function testGetOmiseAccount() {
        $dummy = new stdClass();
        $double = test::double('OmiseAccount', array('retrieve' => $dummy));
        $account = $this->model->getOmiseAccount();
        $this->assertSame($dummy, $account);
    }

    public function testGetOmiseBalance() {
        $dummy = new stdClass();
        $double = test::double('OmiseBalance', array('retrieve' => $dummy));
        $balance = $this->model->getOmiseBalance();
        $this->assertSame($dummy, $balance);
    }
}