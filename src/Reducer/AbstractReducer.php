<?php
/**
 * File: src/Reducer/AbstractReducer.php
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author  Rafael Fontes <rafael.fontes@gmx.com>
 * @license https://choosealicense.com/licenses/unlicense Unlicense
 * @link    https://github.com/rafaelfontes/php-mars
 */

namespace RFontes\PHPMars\Reducer;

use \RFontes\PHPMars\Reducer\InvokableReducerInterface;
use \RFontes\PHPMars\Helper\ReflectionHelper;
use \RFontes\PHPMars\Action\ActionInterface;

/**
 * @class  \Rfontes\PHPMars\Reducer\AbstractReducer
 * @author Rafael Fontes <rafael.fontes@gmx.com>
 */
abstract class AbstractReducer implements InvokableReducerInterface
{
    /**
     * Map of action types for methods in this instance
     *
     * Ex:
     * ```php
     * array( 'actionType' => function($state, $action) { return $state } );
     * ```
     *
     * @var array
     */
    private $actionTypeToMethodMap = array();

    public function __construct()
    {
        ReflectionHelper::filterMethodsOfObjectByDocComment(
            $this,
            function ($name, $value, $method) {
                if ($name == "action") {
                    $this->actionTypeToMethodMap[$value] = $method;
                }
            }
        );
    }

    private function isTypeMapped($type)
    {
        return isset($this->actionTypeToMethodMap[$type]);
    }

    private function reduce($state, ActionInterface $action)
    {
        return $this->actionTypeToMethodMap[$action->getType()]->invoke($this, $state, $action);
    }

    /**
     * Invoke the Reducer
     *
     * @param mixed $state  the current state of the reducer
     * @param mixed $action the action to be performed
     *
     * @return mixed the new state of the reducer
     */
    public function __invoke($state, ActionInterface $action)
    {
        if ($this->isTypeMapped($action->getType())) {
            return $this->reduce($state, $action);
        }
        return $state;
    }
}
