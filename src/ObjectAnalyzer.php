<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JaimeLopez\Testuals;

class ObjectAnalyzer
{
    const REFERENCE_PREFIX = '@';

    /** @var mixed */
    private $object;

    /**
     * @param mixed $dependency
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @return bool
     */
    public function isPrimitive()
    {
        $primitiveTypes = [
            'boolean',
            'integer',
            'double',
            'float',
            'string',
            'array',
            'NULL'
        ];

        $type = gettype($this->object);

        return in_array($type, $primitiveTypes);
    }

    /**
     * @return bool
     */
    public function isReference()
    {
        if (!is_string($this->object)) {
            return false;
        }

        return strpos($this->object, self::REFERENCE_PREFIX) === 0;
    }

    /**
     * @return string|null
     */
    public function getReference()
    {
        if (!$this->isReference()) {
            return;
        }

        return substr($this->object, strlen(self::REFERENCE_PREFIX));
    }
}