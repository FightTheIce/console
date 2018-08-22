<?php

namespace FightTheIce\Console\Events\Output;

use Webmozart\Assert\Assert;

class Info implements BasicOutputInterface
{
    protected $message;
    protected $command;
    public $verbosity;

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
