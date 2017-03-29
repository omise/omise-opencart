<?php
require_once(__DIR__.'/../controller.php');
require_once(__DIR__.'/../../model/model.php');
require_once(__DIR__.'/../../../../src/admin/controller/payment/omise.php');

class ControllerPaymentOmiseTest extends PHPUnit_Framework_TestCase {
    public function setup() {
        $this->controller = new ControllerPaymentOmise();
        $this->controller->_admin = true;
    }

    public function tearDown() {
    }

    public function testInstallSuccess() {
        $model_payment_omise = $this->controller->mockModel('payment/omise', array('install'));

        $model_payment_omise->expects($this->once())
            ->method('install')
            ->willReturn(true);

        $this->controller->install();
    }

    public function testInstallFailure() {
        $model_payment_omise = $this->controller->mockModel('payment/omise', array('install'));

        $model_payment_omise->expects($this->once())
            ->method('install')
            ->willReturn(false);
        $this->controller->load->expects($this->once())
            ->method('controller')
            ->with('extension/payment/uninstall');

        $this->controller->install();
    }

    public function testIndex() {
        $view = new stdClass();

        $this->controller->load->expects($this->once())
            ->method('view')
            ->with('payment/omise.tpl')
            ->willReturnCallback(function($name, $data) use ($view) {
                $this->assertEquals(1, $data['omise_status']);
                $this->assertEquals('l10n_heading_title', $data['heading_title']);
                $this->assertEquals('payment/omise__token=tok1__SSL', $data['action']);
                return $view;
            });
        $this->controller->response->expects($this->once())
            ->method('setOutput')
            ->with($view);

        $this->controller->config->set('omise_status', 1);
        $this->controller->request->server['REQUEST_METHOD'] = 'GET';
        $this->controller->session->data['token'] = 'tok1';

        $this->controller->index();
    }

    public function testIndexFlash() {
        $view = new stdClass();

        $this->controller->load->expects($this->once())
            ->method('view')
            ->with('payment/omise.tpl')
            ->willReturnCallback(function($name, $data) use ($view) {
                $this->assertEquals('Success!!!', $data['success']);
                $this->assertEquals('Error T_T', $data['error_warning']);
                $this->assertEquals(1, $data['omise_status']);
                $this->assertEquals('l10n_heading_title', $data['heading_title']);
                $this->assertEquals('payment/omise__token=tok1__SSL', $data['action']);
                return $view;
            });
        $this->controller->response->expects($this->once())
            ->method('setOutput')
            ->with($view);

        $this->controller->config->set('omise_status', 1);
        $this->controller->request->server['REQUEST_METHOD'] = 'GET';
        $this->controller->session->data['token'] = 'tok1';
        $this->controller->session->data['success'] = 'Success!!!';
        $this->controller->session->data['error'] = 'Error T_T';

        $this->controller->index();
    }

    public function testIndexEmptyPost() {
        $this->controller->response->expects($this->once())
            ->method('redirect')
            ->with('payment/omise__token=tok1__SSL');

        $this->controller->request->server['REQUEST_METHOD'] = 'POST';
        $this->controller->session->data['token'] = 'tok1';

        $this->controller->index();
    }

    public function testIndexPost() {
        $this->controller->response->expects($this->once())
            ->method('redirect')
            ->with('payment/omise__token=tok1__SSL');

        $this->controller->request->server['REQUEST_METHOD'] = 'POST';
        $this->controller->session->data['token'] = 'tok1';

        $this->controller->index();
    }

    public function testSubmitTransferGET() {
        $this->controller->response->expects($this->once())
            ->method('redirect')
            ->with('payment/omise__token=tok1__SSL');

        $this->controller->request->server['REQUEST_METHOD'] = 'GET';
        $this->controller->session->data['token'] = 'tok1';

        $this->controller->submitTransfer();

        $this->assertEquals('l10n_error_l10n_error_allowed_only_post_method', $this->controller->session->data['error']);
    }
}