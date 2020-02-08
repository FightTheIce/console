<?php

namespace FightTheIce\Console\Events\Output;

class Listing {
    /**
     * @var mixed
     */
    public $elements;
    /**
     * @var mixed
     */
    public $command;

    /**
     * @param $elements
     * @param $command
     */
    public function __construct($elements, $command) {
        $this->elements = $elements;
        $this->command  = $command;
    }

    /**
     * @return mixed
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
