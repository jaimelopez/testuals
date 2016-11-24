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
use Santa\Testuals\Test\Validation;

class Test
{
    /** @var string */
    private $classname;

    /** @var array */
    private $dependencies;

    /** @var Validation[] */
    private $validations;

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
     * @return Validation[]
     */
    public function getValidations()
    {
        return $this->validations;
    }

    /**
     * @param Validation[] $validations
     */
    public function setValidations($validations)
    {
        $this->validations = $validations;

        return $this;
    }

    public function execute()
    {
        new Executor($this);
    }
}