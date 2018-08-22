<?php

namespace FightTheIce\Console\Events\Output;

use Webmozart\Assert\Assert;

class Note implements BasicOutputInterface
{
    protected $message;
    protected $command;

    public function __construct($message, $command)
    {
        Assert::string($message);
        Assert::isInstanceOf($command, 'Symfony\Component\Console\Command\Command');

        $this->message = $message;
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
}
