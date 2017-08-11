<?php
/**
 * File: src/Middleware/MiddlewareInterface.php
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

namespace RFontes\PHPMars\Middleware;

use RFontes\Action\ActionInterface;

interface MiddlewareInterface
{
    public function actionHandler(ActionInterface $action, callable $next);
}
