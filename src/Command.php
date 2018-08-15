<?php

namespace FightTheIce\Console;

use Illuminate\Console\Command as I_Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Command extends I_Command
{
    /**
     * IO
     * Additional Input/Output features
     *
     * @access protected
     * @var null
     */
    protected $io = null;

    /**
     * Enabled
     * Is this command enabled
     *
     * @access protected
     * @var boolean
     */
    protected $enabled = true;

    protected $screen = null;

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->screen = new Screen($input, $output, $this->getApplication()->getMonolog());
        $this->screen->writeToMonologOnly($this->signature);
        $this->screen->writeToMonologOnly(implode($_SERVER['argv']));

        //variable to hold the method name
        $method = '';

        //does the handle method exists?
        if (method_exists($this, 'handle')) {
            //yes the handle method exists
            $method = 'handle';
        } elseif (method_exists($this, 'fire')) {
            //the fire method exists
            $method = 'fire';
        }

        //if we have a method lets try to execute it
        if (!empty($method)) {
            //return the executed method
            return call_user_func_array(array($this, $method), array());
        } else {
            //error out if we don't have a method
            $this->errorExit('Unable to find execution [handle, or fire] method!');
        }
    }

    /**
     * errorExit
     * Show an error message and exit
     *
     * @access public
     * @param  string $message - A string containing the
     */
    public function errorExit($message = null)
    {
        //show a nice error message
        $this->error($message);

        //exit the script
        exit;
    }

    /**
     * run
     * Before we run our command logic lets try to setup some additional properties
     *
     * @access public
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        //setup the additional input/output style stuff
        $this->io = new SymfonyStyle($input, $output);

        #@TODO: add a title

        //run the parent
        parent::run($input, $output);
    }

    /**
     * title
     * Setup a command title
     *
     * @access public
     * @param  string $title
     */
    public function title($title = '')
    {
        $this->io->title($title);
    }

    /**
     * section
     * Setup section text
     * @param  string $text
     */
    public function section($text = '')
    {
        $this->io->section($text);
    }

    /**
     * text
     * Output some text
     *
     * @access public
     * @param  string $message
     */
    public function text($message)
    {
        $this->io->text($message);
    }

    /**
     * listing
     * Output a listing
     *
     * @access public
     * @param  string $message
     */
    public function listing($message)
    {
        $this->io->listing($message);
    }

    /**
     * newLine
     * Output a new line (empty)
     *
     * @access public
     */
    public function newLine()
    {
        $this->io->newLine();
    }

    /**
     * note
     * Leave a note
     *
     * @access public
     * @param  string $message
     */
    public function note($message)
    {
        $this->io->note($message);
    }

    /**
     * caution
     * Output a caution note
     *
     * @access public
     * @param  string $message
     */
    public function caution($message)
    {
        $this->io->caution($message);
    }

    /**
     * Success
     * Leave a success message
     *
     * @access public
     * @param  string $message
     */
    public function success($message)
    {
        $this->io->success($message);
    }

    /**
     * warning
     * Leave a warning note
     *
     * @access public
     * @param  string $message
     */
    public function warning($message)
    {
        $this->io->warning($message);
    }

    /**
     * isEnabled
     * Is this command enabled
     *
     * @access public
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * getContainer
     * Return the base container from the console application
     *
     * @access public
     * @return Illuminate\Container\Container
     */
    public function getContainer()
    {
        return $this->getApplication()->getContainer();
    }

    /**
     * newProgressBar
     * Return a new progress bar
     *
     * @access public
     * @param  int $int - An integer defining the number of steps in the progress bar
     */
    public function newProgressBar($int)
    {
        return $this->output->createProgressBar($int);
    }
}
