<?php

namespace Santa\Testuals\Test\Dependency;

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