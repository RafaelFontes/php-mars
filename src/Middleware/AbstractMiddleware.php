<?php
/**
 * File: src/Middleware/AbstractMiddleware.php
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
use RFontes\PHPMars\Middleware\MiddlewareInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    private $getStateFunc;
    private $dispatchFunc;

    public function __invoke(callable $getState, callable $dispatch)
    {
        $this->getStateFunc = $getState;
        $this->dispatchFunc = $dispatch;

        return function (callable $next) {
            return function (ActionInterface $action) use ($next) {
                return $this->actionHandler($action, $next);
            };
        };
    }

    public function getState()
    {
        return call_user_func($this->getStateFunc);
    }

    public function dispatch($action)
    {
        return call_user_func($this->getStateFunc, $action);
    }
}
