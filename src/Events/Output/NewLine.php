<?php

namespace FightTheIce\Console\Events\Output;

class NewLine
{
    public $count;
    public $command;

    public function __construct($count, $command)
    {
        $this->count   = $count;
        $this->command = $command;
    }
}
