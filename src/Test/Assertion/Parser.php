<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test\Assertion;

use InvalidArgumentException;
use Santa\Testuals\Test\Assertion;

class Parser
{
    /** @var string */
    private $file;

    /** @var array */
    private $items;

    /**
     * @param string $file
     * @param array  $items
     */
    public function __construct($file, array $items)
    {
        $this->file = $file;
        $this->items = $items;
    }

    /**
     * @return Assertion[]
     */
    public function get()
    {
        $assertions = [];

        foreach ($this->items as $item) {
            $this->validate($item);

            $assertion = new Assertion();
            $assertion->setThat($item['that']);

            if (isset($item['value'])) {
                $assertion->setValue($item['value']);
            }

            $assertions[] = $assertion;
        }

        return $assertions;
    }

    /**
     * @param array $data
     */
    private function validate(array $data)
    {
        $requiredParameters = ['that'];

        $validParameters = array_merge([
            'value'
        ], $requiredParameters);

        foreach ($requiredParameters as $parameter) {
            if (!key_exists($parameter, $data)) {
                throw new InvalidArgumentException(
                    sprintf('%s assertion parameter is missing in %s test file', $parameter, $this->file),
                    0
                );
            }
        }

        foreach ($data as $parameter => $value) {
            if (!in_array($parameter, $validParameters)) {
                throw new InvalidArgumentException(sprintf(
                    'Unknown assertion parameter %s in test file %s', $parameter, $this->file
                ));
            }
        }
    }
}