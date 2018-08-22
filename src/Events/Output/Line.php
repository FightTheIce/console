<?php

namespace FightTheIce\Console\Events\Output;

use Webmozart\Assert\Assert;

class Line implements BasicOutputInterface
{
    protected $message;
    protected $command;
    public $style;
    public $verbosity;

    public function __construct($message, $style, $verbosity, $command)
    {
        Assert::string($message);
        Assert::isInstanceOf($command, 'Symfony\Component\Console\Command\Command');

        $this->message   = $message;
        $this->style     = $style;
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
