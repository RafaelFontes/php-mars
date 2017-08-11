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

namespace RFontes\PHPMars\Middleware;

use RFontes\Action\ActionInterface;
use RFontes\PHPMars\Middleware\AbstractMiddleware;

final class ActionLoggerMiddleware extends AbstractMiddleware
{
    private $writer;

    public function __construct(callable $writer = null)
    {
        if ($writer) {
            $this->writer = $writer;
        }
    }

    public function actionHandler(ActionInterface $action, callable $next)
    {
        if ($this->writer) {
            call_user_func($this->writer, $action);
        } else {
            echo $action->serialize() . PHP_EOL;
        }

        return $next($action);
    }
}
