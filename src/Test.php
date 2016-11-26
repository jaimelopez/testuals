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

use Santa\Testuals\Test\Assertion;
use Santa\Testuals\Test\Dependency;
use Santa\Testuals\Test\Expectation;

class Test
{
    const FAILED = 'failed';
    const PASSED = 'passed';
    const DISABLED = 'disabled';

    /** @var string */
    private $name;

    /** @var string */
    private $classname;

    /** @var Dependency[] */
    private $dependencies;

    /** @var string */
    private $methodName;

    /** @var array */
    private $arguments;

    /** @var Assertion[] */
    private $assertions;

    /** @var Expectation[] */
    private $expectations;

    /** @var bool */
    private $disabled;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Test
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

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
     * @return Dependency[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param Dependency[] $dependencies
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
     * @return Assertion[]
     */
    public function getAssertions()
    {
        return $this->assertions;
    }

    /**
     * @param Assertion[] $assertions
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

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param boolean $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }
}