<?php
/**
 * File: src/Helper/ReflectionHelper.php
 *
 * LICENSE: This source file is subject to the license Unlicense that is available
 * through the world-wide-web at the following URI:
 * https://choosealicense.com/licenses/unlicense
 *
 * @author  Rafael Fontes <rafael.fontes@gmx.com>
 * @license https://choosealicense.com/licenses/unlicense Unlicense
 * @link    https://github.com/rafaelfontes/php-mars
 */

namespace RFontes\PHPMars\Helper;

class ReflectionHelper
{
    /**
     * Check if passing `$item` to every filter inside the $filters variable
     * will return true
     *
     * @param iterable $filters
     * @param mixed $item
     *
     * @return array
     */
    public static function filterEvery($filters, $item)
    {
        $output = true;

        foreach ($filters as $filter) {
            if (! $filter($item)) {
                $output = false;
                break;
            }
        }

        return $output;
    }

    /**
     * Filter from `iterable` the items that can be checked by every filter inside the
     * `$filters` variable
     *
     * @param iterable $iterable
     * @param iterable $filters
     *
     * @return array
     */
    public static function filterIterable($iterable, $filters)
    {
        $output = array();

        foreach ($iterable as $item) {
            if (self::filterEvery($filters, $item)) {
                $output[] = $item;
            }
        }

        return $output;
    }

    public static function mapDocCommentAttributes(\ReflectionMethod $method)
    {
        $output = array();
        $matches = array();
        \preg_match_all("/@(?<attribute>([^ ]+)) (?<value>([^@\n]+))/", $method->getDocComment(), $matches);
        if (! empty($matches) && isset($matches['attribute'])) {
            foreach ($matches['attribute'] as $index => $attributeName) {
                $output[] = array("name" => $attributeName,
                                  "value" => $matches['value'][$index]);
            }
        }
        return $output;
    }

    /**
     * Get methods of the given object based on docComment filter
     * ```php
     * // this would filter all the methods with the @foo attribute on the docComment
     * ReflectionHelper::filterMethodsOfObjectByDocComment(
     *      $this,
     *      function ($name, $value, $method) {
     *          return ($name == "foo");
     *      }
     * );
     * ```
     *
     * @param \stdClass $object
     * @param closure $methodFilter
     * @param closure $docCommentFilter
     *
     * @return array
     */
    public static function filterMethodsOfObjectByDocComment($object, $docCommentFilter = null)
    {
        $output = array();
        $reflection = new \ReflectionClass(\get_class($object));
        foreach ($reflection->getMethods() as $method) {
            foreach (self::mapDocCommentAttributes($method) as $map) {
                if ($docCommentFilter($map['name'], $map['value'], $method)) {
                    $output[] = $method;
                }
            }
        }
        return $output;
    }
}
