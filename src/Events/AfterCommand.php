<?php

namespace FightTheIce\Console\Events;

class AfterCommand
{
    protected $input;
    protected $output;
    protected $command;

    public function __construct($input, $output, $command)
    {
        $this->input   = $input;
        $this->output  = $output;
        $this->command = $command;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getCommand()
    {
        return $this->command;
    }
}
