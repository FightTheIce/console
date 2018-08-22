<?php

namespace FightTheIce\Console\Events\Output;

class Ask implements AdvancedInputInterface, BasicOutputInterface
{
    protected $question;
    public $default;
    protected $answer;
    protected $command;

    public function __construct($question, $default, $answer, $command)
    {
        $this->question = $question;
        $this->default  = $default;
        $this->answer   = $answer;
        $this->command  = $command;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getMessage()
    {
        return $this->question;
    }

    public function getCommand()
    {
        return $this->command;
    }
}
