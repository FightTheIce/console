<?php

namespace FightTheIce\Console;

use Symfony\Component\Console\Application as S_Application;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Webmozart\Assert\Assert;

class Application extends S_Application
{
    /**
     * container
     * The container object
     *
     * @access protected
     * @var null
     */
    protected $container = null;

    /**
     * containerSet
     * A boolean value to determine if the container
     * object has been set
     *
     * @access protected
     * @var boolean
     */
    protected $containerSet = false;

    /**
     * dispatcher
     * Event Dispatcher
     *
     * @access protected
     * @var null
     */
    protected $dispatcher = null;

    /**
     * __construct
     * Class construct
     *
     * @access public
     * @param string $name      Name of the console application
     * @param string $version   Version of the console application
     * @param mixed  $container Container object
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN', $container = null, $useEvents = true)
    {
        //make sure the name is a string
        Assert::string($name);

        //make sure the version is a string
        Assert::string($version);

        //if our container object is not null then lets set it
        if (null !== $container) {
            $this->setContainer($container);
        }

        //now call the parent construct
        parent::__construct($name, $version);

        //should we fire events?
        if ($useEvents == true) {
            $this->dispatcher = new EventDispatcher();
            $this->setDispatcher($this->dispatcher);
        }
    }

    /**
     * getDispatcher
     * Return the dispatcher if one is set otherwise it
     * throws an exception
     *
     * @access public
     * @return Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * getContainer
     * Returns the container object if one is set
     * otherwise it will throw an exception
     *
     * @access public
     * @return mixed
     */
    public function getContainer()
    {
        if (null == $this->container) {
            throw new \ErrorException('The container object is not set!');
        }

        return $this->container;
    }

    /**
     * setContainer
     * Set the container object
     *
     * @access public
     * @param mixed $container
     */
    public function setContainer($container)
    {
        //is there an actual container set already
        //if so throw an exception
        if ($this->containerSet == true) {
            throw new \ErrorException('The container has already been set');
        }

        //set the container object
        $this->container = $container;

        //set the containerSet property to true
        $this->containerSet = true;

        //return this
        return $this;
    }
}
