<?php
use AspectMock\Test as test;

require_once __DIR__.'/../../../../src/catalog/model/payment/omise.php';

class ModelPaymentOmiseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->registry = new MockRegistry();
        $this->model = new ModelPaymentOmise($this->registry);
    }

    /**
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        test::clean();
    }

    public function testGetMethod()
    {
        $this->model->config->set('omise_sort_order', 99);

        $method = $this->model->getMethod('Bangkok', 1500);

        $this->assertEquals('omise', $method['code']);
        $this->assertEquals('l10n_text_title', $method['title']);
        $this->assertEquals(99, $method['sort_order']);
    }

    public function testGetMethodWithTitleConfigured()
    {
        $this->model->config->set('omise_payment_title', 'Foo');

        $method = $this->model->getMethod('Bangkok', 1500);

        $this->assertEquals('omise', $method['code']);
        $this->assertEquals('Foo', $method['title']);
        $this->assertNull($method['sort_order']);
    }

    public function testRetrieveOmiseKeys()
    {
        $keys = $this->model->retrieveOmiseKeys();

        $this->assertEquals('', $keys['pkey']);
        $this->assertEquals('', $keys['skey']);
    }

    public function testRetrieveOmiseKeysTestMode()
    {
        $this->model->config->set('omise_status', 1);
        $this->model->config->set('omise_test_mode', 1);
        $this->model->config->set('omise_pkey_test', 'pkey_test');
        $this->model->config->set('omise_skey_test', 'skey_test');

        $keys = $this->model->retrieveOmiseKeys();

        $this->assertEquals('pkey_test', $keys['pkey']);
        $this->assertEquals('skey_test', $keys['skey']);
    }

    public function testRetrieveOmiseKeysLiveMode()
    {
        $this->model->config->set('omise_status', 1);
        $this->model->config->set('omise_pkey', 'pkey');
        $this->model->config->set('omise_skey', 'skey');

        $keys = $this->model->retrieveOmiseKeys();

        $this->assertEquals('pkey', $keys['pkey']);
        $this->assertEquals('skey', $keys['skey']);
    }
}
