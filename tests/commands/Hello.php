<?php

class Hello extends FightTheIce\Console\Command {
    /**
     * @var string
     */
    protected $signature = 'hello {type? : What type should we run?}';

    /**
     * @return int
     */
    public function handle() {

        $this->errorExit('ErrorExit', false);
        $this->title('Title');
        $this->section('Section');
        $this->text('Text');
        $this->listing(array('List-1', 'List-2', 'List-3'));
        $this->newLine(1);
        $this->note('Note');
        $this->caution('Caution');
        $this->success('Success');
        $this->warning('Warning');

        $this->confirm('Confirm', 'Yes');
        $this->ask('Ask', 'Ask');
        $this->anticipate('Anticipate', array('Yes', 'No', 'Anticipate'), 'Anticipate');
        $this->askWithCompletion('Ask With Completion', array('Yes', 'No', 'AskWithCompletion'), 'AskWithCompletion');
        $this->secret('Secret', function () {
            echo 'Fallback';
        });
        $this->choice('Choice', array('Choice1', 'Choice2', 'Choice3'), 0, 3, null);
        $this->table(array('Col1', 'Col2', 'Col3'), array(array('Col1' => 'Row1-Col1', 'Col2' => 'Row1-Col2', 'Col3' => 'Row1-Col3')));
        $this->info('Info');
        $this->line('Line');
        $this->comment('Comment');
        $this->question('Question');
        $this->error('Error');
        $this->warn('Warn');
        $this->alert('Alert');

        /*
        $moo = $this->call('say', array(
        'name' => 'William',
        ));
         */

        return 0;
    }
}
