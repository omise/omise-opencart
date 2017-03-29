<?php
class Controller {
    public $request;

    public $response;
    
    public $load;

    public $document;

    public $language;

    public $config;

    public $url;

    public $session;

    /**
     * Admin mode.
     */
    public $_admin;

    private $_generator;

    private $_configs = array();

    private $_models = array();

    public function __construct() {
        $this->_generator = new PHPUnit_Framework_MockObject_Generator(); 

        $this->request = new stdClass();
        $this->request->server = array();
        $this->request->get = array();
        $this->request->post = array();

        $this->session = new stdClass();
        $this->session->data = array();

        $this->document = $this->getMock('stdClass', array('setTitle'));

        $this->load = $this->getMock('stdClass', array('model', 'controller', 'language', 'library', 'view'));
        $this->load
            ->method('model')
            ->willReturnCallback(function($name) {
                $canon_name = 'model_'.str_replace(array('/'), array('_'), $name);
                $this->$canon_name = $this->mockModel($name);
            });
        $this->load
            ->method('library')
            ->willReturnCallback(function($name) {
                $file = __DIR__.'/../../../src/system/library/'.$name.'.php';
                if (file_exists($file)) {
                    require_once($file);
                }
            });

        $this->response = $this->getMock('stdClass', array('setOutput', 'redirect'));

        $this->config = $this->getMock('stdClass', array('get', 'set'));
        $this->config
            ->method('get')
            ->willReturnCallback(function($key) {
                if (!isset($this->_configs[$key])) {
                    return null;
                }

                return $this->_configs[$key];
            });

        $this->config
            ->method('set')
            ->willReturnCallback(function($key, $value) {
                $this->_configs[$key] = $value;
            });

        $this->language = $this->getMock('stdClass', array('get'));
        $this->language
            ->method('get')
            ->willReturnCallback(function($key) {
                return 'l10n_'.$key;
            });

        $this->url = $this->getMock('stdClass', array('link'));
        $this->url
            ->method('link')
            ->willReturnCallback(function($route, $args, $secure) {
                return $route.'__'.$args.'__'.$secure;
            });
    }

    public function mockModel($name, $methods = array()) {
        if (!isset($this->_models[$name])) {
            $clazz = 'Model'.str_replace(' ', '', ucwords(str_replace(array('/','_'), array(' ', ' '), $name)));
            if ($this->_admin) {
                $file = __DIR__.'/../../../src/admin/model/'.$name.'.php';
            } else {
                $file = __DIR__.'/../../../src/catalog/model/'.$name.'.php';
            }
            if (file_exists($file)) {
                require_once($file);
            }
            $this->_models[$name] = $this->getMock($clazz, $methods);
        }

        return $this->_models[$name];
    }

    private function getMock($originalClassName, $methods = array(), array $arguments = array(), $mockClassName = '', $callOriginalConstructor = true, $callOriginalClone = true,      $callAutoload = true, $cloneArguments = false, $callOriginalMethods = false, $proxyTarget = null) {
        $mockObject = $this->_generator->getMock(
            $originalClassName,
            $methods,
            $arguments,
            $mockClassName,
            $callOriginalConstructor,
            $callOriginalClone,
            $callAutoload,
            $cloneArguments,
            $callOriginalMethods,
            $proxyTarget
        );

        return $mockObject;
    }
}