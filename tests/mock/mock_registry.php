<?php
class MockRegistry {
    private $data = array();
    private $admin = false;
    private $generator;

    public function __construct($mode) {
        if ($mode == 'admin') {
            $this->_admin = true;
        }

        $this->generator = new PHPUnit_Framework_MockObject_Generator(); 

        $this->data['request'] = $this->getRequest();
        $this->data['session'] = $this->getSession();
        $this->data['document'] = $this->getDocument();
        $this->data['load'] = $this->getLoader();
        $this->data['response'] = $this->getResponse();
        $this->data['config'] = $this->getConfig();
        $this->data['language'] = $this->getLanguage();
        $this->data['url'] = $this->getURL();
        $this->data['db'] = $this->getDB();
    }

    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    public function has($key) {
        return isset($this->data[$key]);
    }

    public function mockModel($name, $methods = array()) {
        if (!isset($this->_models[$name])) {
            $clazz = 'Model'.str_replace(' ', '', ucwords(str_replace(array('/','_'), array(' ', ' '), $name)));
            if ($this->_admin) {
                $file = __DIR__.'/../../src/admin/model/'.$name.'.php';
            } else {
                $file = __DIR__.'/../../src/catalog/model/'.$name.'.php';
            }
            if (file_exists($file)) {
                require_once($file);
            }
            if (class_exists($clazz)) {
                $this->_models[$name] = $this->getMock($clazz, $methods, array($this));
            } else {
                $this->_models[$name] = $this->getMock('stdClass', $methods, array());
            }
        }

        return $this->_models[$name];
    }

    private function getMock($originalClassName, $methods = array(), array $arguments = array(), $mockClassName = '', $callOriginalConstructor = true, $callOriginalClone = true,      $callAutoload = true, $cloneArguments = false, $callOriginalMethods = false, $proxyTarget = null) {
        $mockObject = $this->generator->getMock(
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

    private function getRequest() {
        $request = new stdClass();
        $request->server = array();
        $request->get = array();
        $request->post = array();
        return $request;
    }

    private function getSession() {
        $session = new stdClass();
        $session->data = array();
        return $session;
    }

    private function getDocument() {
        return $this->getMock('stdClass', array('setTitle'));
    }

    private function getLoader() {
        $loader = $this->getMock('stdClass', array('model', 'controller', 'language', 'library', 'view'));
        $loader
            ->method('model')
            ->willReturnCallback(function($name) {
                $canon_name = 'model_'.str_replace(array('/'), array('_'), $name);
                $this->data[$canon_name] = $this->mockModel($name);
            });
        $loader
            ->method('library')
            ->willReturnCallback(function($name) {
                $file = __DIR__.'/../../src/system/library/'.$name.'.php';
                if (file_exists($file)) {
                    \AspectMock\Kernel::getInstance()->loadFile($file);
                }
            });
        return $loader;
    }

    private function getResponse() {
        return $this->getMock('stdClass', array('setOutput', 'redirect'));
    }

    private function getConfig() {
        $config = $this->getMock('stdClass', array('get', 'set'));
        $config
            ->method('get')
            ->willReturnCallback(function($key) {
                if (!isset($this->_configs[$key])) {
                    return null;
                }

                return $this->_configs[$key];
            });
        $config
            ->method('set')
            ->willReturnCallback(function($key, $value) {
                $this->_configs[$key] = $value;
            });

        return $config;
    }

    private function getLanguage() {
        $language = $this->getMock('stdClass', array('get'));
        $language
            ->method('get')
            ->willReturnCallback(function($key) {
                return 'l10n_'.$key;
            });

        return $language;
    }

    private function getURL() {
        $url = $this->getMock('stdClass', array('link'));
        $url
            ->method('link')
            ->willReturnCallback(function($route, $args, $secure) {
                return $route.'__'.$args.'__'.$secure;
            });

        return $url;
    }

    private function getDB() {
        $db = $this->getMock('stdClass', array('query'));
        return $db;       
    }
}