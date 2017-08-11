<?php
/**
 * File: src/Action/ActionInterface.php
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

interface ActionInterface
{
    /**
     * Returns the type of the action
     */
    public function getType();

    /**
     * Returns a serialized string of the action
     * @return string
     */
    public function serizalize();
}
