<?php

namespace FightTheIce\Console\Events\Input;

use FightTheIce\Console\Events\Output\BasicOutputInterface;

class Secret implements AdvancedInputInterface, BasicOutputInterface {
    /**
     * @var mixed
     */
    public $question;
    /**
     * @var mixed
     */
    public $fallback;
    /**
     * @var mixed
     */
    public $answer;
    /**
     * @var mixed
     */
    public $command;

    /**
     * @param $question
     * @param $fallback
     * @param $answer
     * @param $command
     */
    public function __construct($question, $fallback, $answer, $command) {
        $this->question = $question;
        $this->fallback = $fallback;
        $this->answer   = $answer;
        $this->command  = $command;
    }

    /**
     * @return mixed
     */
    public function getAnswer() {
        return $this->answer;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
