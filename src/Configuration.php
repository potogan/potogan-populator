<?php

namespace Potogan\Populator;

class Configuration
{
    /**
     * Option values.
     *
     * @var array
     */
    protected $options;

    /**
     * Class constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * Gets option value.
     *
     * @param string $name    Option name.
     * @param mixed  $default Fallback value.
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if ($this->has($name)) {
            return $this->options[$name];
        }

        return $default;
    }

    /**
     * Sets an option value.
     * 
     * @param string $name  Option name.
     * @param mixed  $value Option value
     *
     * @return $this
     */
    public function set($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * Checks if options exists.
     *
     * @param string $name Option name.
     * 
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->options[$name]);
    }
}