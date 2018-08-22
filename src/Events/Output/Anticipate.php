<?php

namespace FightTheIce\Console\Events\Output;

class Anticipate implements AdvancedInputInterface, BasicOutputInterface
{
    public $question;
    public $choices;
    public $default;
    public $answer;
    public $command;

    public function __construct($question, $choices, $default, $answer, $command)
    {
        $this->question = $question;
        $this->choices  = $choices;
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
