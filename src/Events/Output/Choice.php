<?php

namespace FightTheIce\Console\Events\Output;

class Choice implements AdvancedInputInterface, BasicOutputInterface
{
    public $question;
    public $choices;
    public $default;
    public $attempts;
    public $multiple;
    public $answer;
    public $command;

    public function __construct($question, $choices, $default, $attempts, $multiple, $answer, $command)
    {
        $this->question = $question;
        $this->choices  = $choices;
        $this->default  = $default;
        $this->attempts = $attempts;
        $this->multiple = $multiple;
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
