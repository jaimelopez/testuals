<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JaimeLopez\Testuals\Test\Assertion;

use JaimeLopez\Testuals\Test\Assertion;

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
        $validator = new Validator();
        $validator->validate($data, $this->file);
    }
}