<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test\Validation;

class Assertion
{
    /** @var string */
    private $that;

    /** @var mixed */
    private $value;

    /**
     * @param string $that
     * @param mixed $value
     */
    public function __construct($that, $value)
    {
        $this->that = $that;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getThat()
    {
        return $this->that;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}