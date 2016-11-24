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

class ObjectAnalyzer
{
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
}