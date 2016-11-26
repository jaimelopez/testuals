<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test;

class Assertion
{
    /** @var string */
    private $that;

    /** @var mixed */
    private $value;

    /**
     * @return string
     */
    public function getThat()
    {
        return $this->that;
    }

    /**
     * @param string $that
     * @return Assertion
     */
    public function setThat($that)
    {
        $this->that = $that;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Assertion
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}