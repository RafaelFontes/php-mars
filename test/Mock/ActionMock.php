<?php
/**
 * File: test/Mock/ActionMock
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author  Rafael Fontes <rafael.fontes@gmx.com>
 * @license https://choosealicense.com/licenses/unlicense Unlicense
 * @link    https://github.com/rafaelfontes
 */

namespace test\RFontes\PHPMars\Mock;

use RFontes\PHPMars\Action\ActionInterface;

class ActionMock implements ActionInterface
{
    public function getType()
    {
        return get_class($this);
    }
}
