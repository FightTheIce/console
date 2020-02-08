<?php

namespace FightTheIce\Console\Events\Output;

class Table {
    /**
     * @var mixed
     */
    public $headers;
    /**
     * @var mixed
     */
    public $rows;
    /**
     * @var mixed
     */
    public $style;
    /**
     * @var mixed
     */
    public $command;

    /**
     * @param $header
     * @param $rows
     * @param $style
     * @param $command
     */
    public function __construct($headers, $rows, $style, $command) {
        $this->headers = $headers;
        $this->rows    = $rows;
        $this->style   = $style;
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getRows() {
        return $this->rows;
    }

    /**
     * @return mixed
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * @return mixed
     */
    public function getCommand() {
        return $this->command;
    }
}
