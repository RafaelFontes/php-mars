<?php
/**
 * File: src/Helper/Redux.php
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
namespace RFontes\PHPMars\Helper;

class Redux
{
    private function __construct()
    {
    }

    public static function __callStatic($name, $args)
    {
        if ("UNDEFINED" === $name) {
            return new self;
        }
    }

    public static function composeFunctions(callable ... $functions)
    {
        if (0 == count($functions)) {
            return function ($param) {
                return $param;
            };
        }

        if (1 == count($functions)) {
            return $functions[0];
        }

        $reducer = function ($prev, $next) {
            if (null === $prev) {
                return $next;
            }

            return function ($arg) use ($prev, $next) {
                return $prev($next($arg));
            };
        };

        return array_reduce($functions, $reducer);
    }

    public static function applyMiddleware(...$middlewares)
    {
        return function ($createStore) use ($middlewares) {
            return function ($reducer, $preloadedState, callable $enhancer = null) use ($createStore, $middlewares) {
                $st = $createStore($reducer, $preloadedState, $enhancer);

                $getState = function () use ($st) {
                    return $st->getState();
                };

                $dispatch = function ($action) use ($st) {
                    return $st->dispatchBase($action);
                };

                $chain = array_map(
                    function ($middleware) use ($getState, $dispatch) {
                        return $middleware($getState, $dispatch);
                    },
                    $middlewares
                );

                $composedChain = call_user_func_array(__NAMESPACE__.'\Redux::composeFunctions', $chain);

                $st->setDispatcher($composedChain($dispatch));
                return $st;
            };
        };
    }

    public static function combineReducers(array $reducers)
    {
        $finalReducers = array();

        foreach ($reducers as $key => $reducer) {
            if (\is_callable($reducer)) {
                $finalReducers[$key] = $reducer;
            } else {
                throw new \BadFunctionCallException('Reducer for ' . $key . ' is not callable');
            }
        }

        return function ($state, $action) use ($finalReducers) {
            $nextState = array();
            foreach ($finalReducers as $key => $reducer) {
                $previousStateForKey = isset($state[$key]) ? $state[$key] : self::UNDEFINED();
                $nextStateForKey = $reducer($previousStateForKey, $action);
                $nextState[$key] = $nextStateForKey;
            }
            return $nextState;
        };
    }
}
