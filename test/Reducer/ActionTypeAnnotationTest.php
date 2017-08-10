<?php
/**
 * File: test/Reducer/ActionTypeAnnotationTest.php
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author   Rafael Fontes <rafael.fontes@gmx.com>
 * @license  Unlicense https://choosealicense.com/licenses/unlicense/
 * @link     http://github.com/rafaelfontes/php-mars
 */
namespace test\RFontes\PHPMars\Reducer;

use PHPUnit\Framework\TestCase;
use test\RFontes\PHPMars\Mock\ReducerMock;
use test\RFontes\PHPMars\Mock\ActionMock;

/**
 * @author   Rafael Fontes <rafael.fontes@gmx.com>
 */
class ActionTypeAnnotationTest extends TestCase
{
    public function testAnnotationMapping()
    {
        $reducer = new ReducerMock();
        $state = $reducer(null, new ActionMock());
        $this->assertEquals("yes we can!", $state);
    }
}
