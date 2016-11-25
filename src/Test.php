<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals;

use Santa\Testuals\Test\Executor;
use Santa\Testuals\Test\Validation\Assertion;
use Santa\Testuals\Test\Validation\Expectation;

class Test
{
    /** @var string */
    private $classname;

    /** @var array */
    private $dependencies;

    /** @var string */
    private $methodName;

    /** @var array */
    private $arguments;

    /** @var Assertion[] */
    private $assertions;

    /** @var Expectation[] */
    private $expectations;

    /**
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * @param string $classname
     * @return Test
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;

        return $this;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param array $dependencies
     * @return Test
     */
    public function setDependencies(array $dependencies)
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     * @return Test
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return Test
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getAssertions()
    {
        return $this->assertions;
    }

    /**
     * @param array $assertions
     * @return Test
     */
    public function setAssertions(array $assertions)
    {
        $this->assertions = $assertions;

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
     * @return Test
     */
    public function setExpectations(array $expectations)
    {
        $this->expectations = $expectations;

        return $this;
    }

    public function execute()
    {
        new Executor($this);
    }
}