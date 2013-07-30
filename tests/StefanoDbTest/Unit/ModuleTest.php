<?php
namespace StefanoDbTest\Unit;

use StefanoDb\Module;

class ModuleTest
    extends \PHPUnit_Framework_TestCase
{   
    public function testGetModuleConfig() {
        $module = new Module();
        
        $this->assertTrue(is_array($module->getConfig()));
    }
}