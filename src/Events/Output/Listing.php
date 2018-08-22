<?php

namespace FightTheIce\Console\Events\Output;

class Listing
{
    public $elements;
    public $command;

    public function __construct($elements, $command)
    {
        $this->elements = $elements;
        $this->command  = $command;
    }
}
