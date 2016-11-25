<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ToTest;

class ServiceToTest
{
    /** @var array */
    private $array;

    /** @var OOObject */
    private $object;

    /**
     * @param array    $array
     * @param OOObject $object
     */
    public function __construct(array $array, OOObject $object)
    {
        $this->array = $array;
        $this->object = $object;
    }

    public function methodToTest($argument1)
    {
        return $this->object->method1();
    }
}