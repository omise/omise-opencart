<?php
if (!defined('DB_PREFIX')) {
    define('DB_PREFIX', 'ocu_');
}

require_once(__DIR__.'/../vendor/autoload.php');

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
        'debug' => true,
        'includePaths' => [__DIR__.'/../src/system']
    ]);

require_once(__DIR__.'/mock/controller.php');
require_once(__DIR__.'/mock/mock_registry.php');
require_once(__DIR__.'/mock/model.php');