<?php

namespace FightTheIce\Console\Events\Output;

use Webmozart\Assert\Assert;

class ErrorExit implements BasicOutputInterface
{
    protected $message;
    protected $exit;
    protected $command;

    public function __construct($message, $exit, $command)
    {
        Assert::string($message);
        Assert::boolean($exit);
        Assert::isInstanceOf($command, 'Symfony\Component\Console\Command\Command');

        $this->message = $message;
        $this->exit    = $exit;
        $this->command = $command;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getExit()
    {
        return $this->exit;
    }

    public function willExit()
    {
        return $this->getExit();
    }
}
