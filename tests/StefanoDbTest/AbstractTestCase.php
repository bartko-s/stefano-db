<?php
namespace StefanoDbTest;

use Zend\Test\Util\ModuleLoader;

abstract class AbstractTestCase
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getFreshServiceLocator() {
        $moduleLoader = new ModuleLoader(array(
            'modules' => array(
                'StefanoDb',
            ),
            'module_listener_options' => array(
                'module_paths' => array(

                ),
                'config_glob_paths' => array(
                    __DIR__ . '/conf/{,*.}{dev}.php',
                ),
            ),
        ));

        return $moduleLoader->getServiceManager();
    }
}
