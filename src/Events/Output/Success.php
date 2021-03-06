<?php

namespace FightTheIce\Console\Events\Output;

class Success {
    /**
     * @var mixed
     */
    protected $message;
    /**
     * @var mixed
     */
    protected $command;

    /**
     * @param $message
     * @param $command
     */
    public function __construct($message, $command) {
        $this->message = $message;
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
