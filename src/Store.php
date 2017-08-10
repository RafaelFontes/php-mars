<?php
/**
 * File: src/Store.php
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

namespace RFontes\PHPMars;

use RFontes\PHPMars\Action\StoreInitAction;

final class Store
{
    private $state;
    private $reducer;
    private $dispatching;
    private $dispatcher = null;

    private function __construct()
    {
    }

    public static function create(callable $reducer, $preloadedState = null, callable $enhancer = null)
    {
        if ($enhancer) {
            $callable = $enhancer(__NAMESPACE__ . '\Store::create');
            return $callable($reducer, $preloadedState);
        }

        $st = new self;
        $st->state = $preloadedState;
        $st->reducer = $reducer;

        $st->dispatcher = function ($action) use ($st) {
            return $st->dispatchBase($action);
        };

        $st->dispatch(new StoreInitAction());

        return $st;
    }

    public function setDispatcher(callable $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatchBase($action)
    {
        if ($this->dispatching) {
            throw new Error("Reducers cannot dispatch actions");
        }

        try {
            $this->dispatching = true;
            $this->state = \call_user_func($this->reducer, $this->state, $action);
        } finally {
            $this->dispatching = false;
        }

        return $action;
    }

    public function dispatch($action)
    {
        return \call_user_func($this->dispatcher, $action);
    }

    public function getState()
    {
        return $this->state;
    }
}
