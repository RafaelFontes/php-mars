<?php
/**
 * File: src/Middleware/ActionLoggerMiddleware.php
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

namespace RFontes\PHPMars\Action;

use RFontes\Action\ActionInterface;

abstract class AbstractAction implements ActionInterface
{
    public function getType()
    {
        return get_class($this);
    }
}
