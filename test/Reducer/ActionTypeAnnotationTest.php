<?php
/**
 * Copyright (C) 2017 Rafael Fontes. All Rights Reserved.
 *
 * Use of this source is governed by the LICENSE file found at https://github.com/rafaelfontes/php-mars
 */

use \PHPUnit\Framework\TestCase;

class ActionTypeAnnotationTest extends TestCase 
{
    /**
     * @test 
     */
    public function testIdentifyAction() 
    {
        $this->assertTrue(true); 
    }

    /**
     * @test
     */
    public function justAnotherTest()
    {
        $this->assertFalse(true, "custom message");
    }

}
