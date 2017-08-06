<?php
/**
 * File: src/Reducer/InvokableReducerInterface.php
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

use \RFontes\PHPMars\Action\ActionInterface;

/**
 * Interface to invokable reducers
 * Allow reducers to be called as functions
 * Also be able to be passed as callable arguments
 */
interface InvokableReducerInterface
{
    /**
     * Invoke the Reducer
     *
     * @param mixed $state  the current state of the reducer
     * @param mixed $action the action to be performed
     *
     * @return mixed the new state of the reducer
     */
    public function __invoke($state, ActionInterface $action);
}
