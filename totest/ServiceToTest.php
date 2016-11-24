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
    private $dependency1;

    /**
     * @param array $dependency1
     */
    public function __construct(array $dependency1)
    {
        $this->dependency1 = $dependency1;
    }

    public function methodToTest($argument1)
    {
        printf('This is the first argument %s', $argument1);
    }
}