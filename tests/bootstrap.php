<?php
if (!defined('DB_PREFIX')) {
    define('DB_PREFIX', 'ocu_');
}

require_once(__DIR__.'/../vendor/autoload.php');

$loaders = spl_autoload_functions();

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
        'debug' => true,
        'includePaths' => [__DIR__.'/../src/system']
    ]);
unset($kernel);

class PatchedComposerLocator extends \Go\ParserReflection\Locator\ComposerLocator
{
     public function locateClass($className)
     {
        $className = ltrim($className, '\\');
        return parent::locateClass($className);
     }
}

\Go\ParserReflection\ReflectionEngine::init(new PatchedComposerLocator($loaders[0][0]));
unset($loaders);

require_once(__DIR__.'/mock/controller.php');
require_once(__DIR__.'/mock/mock_registry.php');
require_once(__DIR__.'/mock/model.php');
