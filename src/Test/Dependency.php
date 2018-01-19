<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JaimeLopez\Testuals\Test;

use JaimeLopez\Testuals\Test\Dependency\Behaviour;

class Dependency
{
    /** @var string */
    private $className;

    /** @var array */
    private $properties;

    /** @var Behaviour[] */
    private $behaviours;

    /** @var mixed */
    private $value;

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     * @return Dependency
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return Behaviour[]
     */
    public function getBehaviours()
    {
        return $this->behaviours;
    }

    /**
     * @param Behaviour[] $behaviours
     * @return Dependency
     */
    public function setBehaviours($behaviours)
    {
        $this->behaviours = $behaviours;

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
     * @return Dependency
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValue()
    {
        return !is_null($this->value);
    }
}