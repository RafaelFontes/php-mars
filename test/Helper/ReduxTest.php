<?php
/**
 * File: test/Helper/ReduxTest.php
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author   Rafael Fontes <rafael.fontes@gmx.com>
 * @license  https://choosealicense.com/licenses/unlicense Unlicense
 * @link     https://github.com/rafaelfontes
 */
namespace test\RFontes\PHPMars\Helper;

use \PHPUnit\Framework\TestCase;
use \RFontes\PHPMars\Store;
use \RFontes\PHPMars\Helper\Redux;

class ReduxTest extends TestCase
{

    public function testComposeFunctions()
    {
        $funcPlus2 = function ($x) {
            return $x + 2;
        };

        $funcTimes2 = function ($x) {
            return $x * 2;
        };

        $composedTimes2Plus2 = Redux::composeFunctions($funcPlus2, $funcTimes2);
        $this->assertEquals(22, $composedTimes2Plus2(10));

        $composedPlus2Times2 = Redux::composeFunctions($funcTimes2, $funcPlus2);
        $this->assertEquals(24, $composedPlus2Times2(10));

        $composedPlus2Plus2 = Redux::composeFunctions($funcPlus2, $funcPlus2);
        $this->assertEquals(14, $composedPlus2Plus2(10));

        $composedTimes2Times2 = Redux::composeFunctions($funcTimes2, $funcTimes2);
        $this->assertEquals(40, $composedTimes2Times2(10));
    }

    public function testCombineReducers()
    {
        $reducer1 = function ($state, $action) {
            return 'first reducer';
        };

        $reducer2 = function ($state, $action) {
            return 'me too';
        };

        $combinedReducer = Redux::combineReducers([
            "reducer1" => $reducer1,
            "reducer2" => $reducer2
        ]);

        $state = $combinedReducer(null, null);

        $this->assertEquals("first reducer", $state["reducer1"]);
        $this->assertEquals("me too", $state["reducer2"]);
    }

    public function testApplyMiddleware()
    {
        $reducer = function ($state, $action) {
            if (! is_array($action)) {
                $type = get_class($action);
                $action = (array)$action;
                $action['type'] = $type;
            }
            return ($action['type'] == 'middleware2') ? false : true;
        };

        $middleware = function ($getState, $dispatch) {
            return function ($next) {
                return function ($action) use ($next) {
                    if ($action['type'] != 'middleware') {
                        return $next(['type' => 'middleware2']);
                    }
                    return $next($action);
                };
            };
        };

        $store = Store::create($reducer, null, Redux::applyMiddleware($middleware));
        $this->assertTrue($store->getState());
        $store->dispatch(['type'=> 'middleware']);
        $this->assertTrue($store->getState());
        $store->dispatch(['type'=> 'another']);
        $this->assertFalse($store->getState());
        $store->dispatch(['type'=> 'middleware']);
        $this->assertTrue($store->getState());
    }
}
