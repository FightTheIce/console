<?php

namespace FightTheIce\Console;

use Illuminate\Console\Application as I_Application;
use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Events\Dispatcher as IlluminateDispatcher;
use Symfony\Component\Console\Application as S_Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Application extends I_Application {
    /**
     * @var mixed
     */
    protected $events = null;
    /**
     * @var mixed
     */
    protected $dispatcher = null;

    /**
     * __construct
     * Class construct
     * Sets the application name, and version
     *
     * @access public
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', Container $container = null, Dispatcher $events = null) {
        if (is_null($container)) {
            $container = new IlluminateContainer;
        }

        if (is_null($events)) {
            $events = new IlluminateDispatcher($container);
        }

        $this->events = $events;

        S_Application::__construct($name, $version);

        $this->laravel = $container;
        $this->setAutoExit(false);
        $this->setCatchExceptions(false);

        $events->dispatch(new Events\ArtisanStarting($this));

        $this->bootstrap();

        $this->dispatcher = new EventDispatcher();
        $this->setDispatcher($this->dispatcher);
        $this->setupSymfonyEvents();
    }

    protected function setupSymfonyEvents() {
        /*
        Typical Purposes: Handle exceptions thrown during the execution of a command.

        Whenever an exception is thrown by a command, including those triggered from event listeners, the ConsoleEvents::ERROR event is dispatched. A listener can wrap or change the exception or do anything useful before the exception is thrown by the application.
         */
        $this->dispatcher->addListener(ConsoleEvents::ERROR, function (ConsoleErrorEvent $event) {
            // gets the input instance
            $input = $event->getInput();

            // gets the output instance
            $output = $event->getOutput();

            // gets the command to be executed
            $command = $event->getCommand();

            if ($command instanceof \FightTheIce\Console\Command) {
                if ($command->shouldUseEvents() == true) {
                    $command->getApplication()->getEvents()->dispatch(new Events\Error($event, $input, $output, $command));
                }
            }
        });

        /*
        Typical Purposes: To perform some cleanup actions after the command has been executed.

        After the command has been executed, the ConsoleEvents::TERMINATE event is dispatched. It can be used to do any actions that need to be executed for all commands or to cleanup what you initiated in a ConsoleEvents::COMMAND listener (like sending logs, closing a database connection, sending emails, ...). A listener might also change the exit code.
         */
        $this->dispatcher->addListener(ConsoleEvents::TERMINATE, function (ConsoleTerminateEvent $event) {
            // gets the input instance
            $input = $event->getInput();

            // gets the output instance
            $output = $event->getOutput();

            // gets the command to be executed
            $command = $event->getCommand();

            if ($command instanceof \FightTheIce\Console\Command) {
                if ($command->shouldUseEvents() == true) {
                    $command->getApplication()->getEvents()->dispatch(new Events\Terminate($event, $input, $output, $command));
                }
            }
        });
    }

    /**
     * @return mixed
     */
    public function getContainer() {
        return $this->getLaravel();
    }

    /**
     * @return mixed
     */
    public function getEvents() {
        return $this->events;
    }
}
