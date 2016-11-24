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

use Santa\Testuals\Test\Validation\Assertion;
use Santa\Testuals\Test\Validation\Expectation;
use Santa\Testuals\Test\Validation\Argument;

class Validation
{
    /** @var string */
    private $method;

    /** @var Argument[] */
    private $arguments;

    /** @var Expectation[] */
    private $expectations;

    /** @var Assertion[] */
    private $assertions;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Validation
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return Argument[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param Argument[] $arguments
     * @return Validation
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return Expectation[]
     */
    public function getExpectations()
    {
        return $this->expectations;
    }

    /**
     * @param Expectation[] $expectations
     * @return Validation
     */
    public function setExpectations(array $expectations)
    {
        $this->expectations = $expectations;

        return $this;
    }

    /**
     * @return Assertion[]
     */
    public function getAssertions()
    {
        return $this->assertions;
    }

    /**
     * @param Assertion[] $assertions
     * @return Validation
     */
    public function setAssertions($assertions)
    {
        $this->assertions = $assertions;

        return $this;
    }
}