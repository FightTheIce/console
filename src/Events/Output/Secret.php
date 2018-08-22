<?php

namespace FightTheIce\Console\Events\Output;

class Secret implements AdvancedInputInterface, BasicOutputInterface
{
    public $question;
    public $fallback;
    public $answer;
    public $command;

    public function __construct($question, $fallback, $answer, $command)
    {
        $this->question = $question;
        $this->fallback = $fallback;
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
