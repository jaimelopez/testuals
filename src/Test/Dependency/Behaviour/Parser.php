<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test\Dependency\Behaviour;

use InvalidArgumentException;
use Santa\Testuals\Test\Dependency;
use Santa\Testuals\Test\Dependency\Behaviour;

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
     * @return Behaviour[]
     */
    public function get()
    {
        $behaviours = [];

        foreach ($this->items as $data) {
            $this->validate($data);

            $behaviours[] = new Behaviour($data['call'], $data['return']);
        }

        return $behaviours;
    }

    /**
     * @param mixed $data
     */
    private function validate($data)
    {
        $validator = new Validator();
        $validator->validate($data, $this->file);
    }
}