<?php

namespace FightTheIce\Console\Events;

class Terminate
{
    public $event;
    protected $input;
    protected $output;
    protected $command;

    public function __construct($event, $input, $output, $command)
    {
        $this->event   = $event;
        $this->input   = $input;
        $this->output  = $output;
        $this->comment = $command;
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
