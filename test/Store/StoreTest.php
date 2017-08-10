<?php
/**
 * File: test/Store/StoreTest.php
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author   Rafael Fontes <rafael.fontes@gmx.com>
 * @license  https://choosealicense.com/licenses/unlicense Unlicense
 * @link     https://github.com/rafaelfontes/php-mars
 */

namespace test\RFontes\PHPMars\Store;

use \PHPUnit\Framework\TestCase;

use \RFontes\PHPMars\Store;
use \RFontes\PHPMars\Action\StoreInitAction;

/**
 *
 */
class StoreTest extends TestCase
{
    public function testDispatchInit()
    {
        $reducer = function ($state, $action) {
            return ($action instanceof StoreInitAction) ? 3 : $state;
        };

        $store = Store::create($reducer, 1);

        $this->assertEquals(3, $store->getState());
    }
}
