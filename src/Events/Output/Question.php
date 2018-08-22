<?php

namespace FightTheIce\Console\Events\Output;

use Webmozart\Assert\Assert;

class Question implements BasicOutputInterface
{
    protected $message;
    public $verbosity;
    protected $command;

    public function __construct($message, $verbosity, $command)
    {
        Assert::string($message);
        Assert::isInstanceOf($command, 'Symfony\Component\Console\Command\Command');

        $this->message   = $message;
        $this->verbosity = $verbosity;
        $this->command   = $command;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCommand()
    {
        return $this->command;
    }
}
