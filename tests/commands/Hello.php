<?php

class Hello extends FightTheIce\Console\Command {
    /**
     * @var mixed
     */
    protected $enabled = true;
    /**
     * @var mixed
     */
    protected $useEvents = true;

    /**
     * @var string
     */
    protected $helpText = '';

    /**
     * @var mixed
     */
    protected $singleInstance = false;

    /**
     * @var string
     */
    protected $signature = 'hello {type? : What type should we run?}';

    /**
     * @return int
     */
    public function handle() {
        $this->text('UUID: [' . $this->getUuid() . ']');
        $this->text('DT: [' . $this->getDateTime() . ']');
        $this->text('Global UUID: [' . $this->getContainer()->make('console')->getUuid() . ']');
        $this->text('CMD: [' . $this->getSignature() . ']');

        $this->call('say', array('name' => 'William'));
        //$this->callSilent('hello');

        return 0;
    }
}
