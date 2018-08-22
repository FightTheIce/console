<?php

namespace FightTheIce\Console\Events\Output;

class Table
{
    public $header;
    public $rows;
    public $style;
    public $command;

    public function __construct($header, $rows, $style, $command)
    {
        $this->header  = $header;
        $this->rows    = $rows;
        $this->style   = $style;
        $this->command = $command;
    }
}
