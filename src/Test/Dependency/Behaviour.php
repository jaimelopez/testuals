<?php
/*
 * This file is part of Testuals.
 *
 * (c) Jaime Lopez <jeims.lopez@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace JaimeLopez\Testuals\Test\Dependency;

class Behaviour
{
    /** @var string */
    private $call;

    /** @var string */
    private $return;

    /**
     * @param string $call
     * @param string $return
     */
    public function __construct($call, $return)
    {
        $this->call = $call;
        $this->return = $return;
    }

    /**
     * @return string
     */
    public function getCall()
    {
        return $this->call;
    }

    /**
     * @return string
     */
    public function getReturn()
    {
        return $this->return;
    }
}