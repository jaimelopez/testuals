<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Santa\Testuals\Test\Dependency;

use Santa\Testuals\Test\Dependency;

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
     * @return Dependency[]
     */
    public function get()
    {
        $dependencies = [];

        foreach ($this->items as $id => $data) {
            $dependencies[] = $this->generateDependency($data);
        }

        return $dependencies;
    }

    /**
     * @param mixed $data
     * @return Dependency
     */
    private function generateDependency($data)
    {
        $dependency = new Dependency();

        if (!is_array($data) || !isset($data['class'])) {
            return $dependency->setValue($data);
        }

        $behaviours = isset($data['behaviours'])
            ? $this->generateBehaviours($data['behaviours'])
            : [];

        $dependency->setClassName($data['class'])
            ->setBehaviours($behaviours);

        return $dependency;
    }

    /**
     * @param array $behaviours
     * @return Behaviour[]
     */
    private function generateBehaviours(array $items)
    {
        $parser = new Behaviour\Parser($this->file, $items);

        return $parser->get();
    }
}