<?php
use AspectMock\Test as test;

require_once(__DIR__.'/../../../../src/catalog/controller/payment/omise.php');

class ControllerPaymentOmiseTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->registry = new MockRegistry();
        $this->controller = new ControllerPaymentOmise($this->registry);
    }

    public function tearDown()
    {
        test::clean();
    }

    public function testCheckoutSuccess()
    {
        $model_checkout_order = $this->registry->mockModel('checkout/order', array('getOrder', 'addOrderHistory'));
        $model_checkout_order
            ->method('getOrder')
            ->with(1)
            ->willReturn(array(
                'total' => 1500,
                'currency_code' => 'thb'
            ));
        $model_checkout_order
            ->expects($this->at(0))
            ->method('addOrderHistory')
            ->with(1, 2);

        $this->registry->get('currency')
            ->method('format')
            ->with(1500, 'thb', '', false)
            ->willReturn('1,500 ฿');
        $this->registry->get('currency')
            ->method('getCode')
            ->willReturn('thb');

        $charge_double = test::double('OmiseCharge', array('create' => array(
            'id' => 'id!!',
            'failure_code' => '',
            'authorized' => true,
            'captured' => true
        )));

        $this->controller->session->data['order_id'] = 1;
        $this->controller->request->post['omise_token'] = 'token';
        $this->controller->request->post['description'] = 'description';

        $this->controller->checkout();

        $output = $this->getActualOutput();
        $json = json_decode($output, true);
        $this->assertEquals('id!!', $json['omise']['id']);
        $this->assertEquals('', $json['omise']['failure_code']);
        $this->assertTrue($json['omise']['authorized']);
        $this->assertTrue($json['omise']['captured']);
    }
}
