<?php

namespace Eskirex;

use \Adbar\Dot;


class Bag
{
    /**
     * Bag data
     *
     * @var array
     */
    protected static $collection = [];


    /**
     * Dot notation class
     *
     * @var Dot
     */
    protected $notation;

    /**
     * Bag constructor.
     *
     */
    public function __construct()
    {
        $this->notation = new Dot;
        $this->notation->setReference(static::$collection);
    }


    /**
     * Call dynamic method
     *
     * @param $name
     * @param $arguments
     * @return mixed|$this|null
     */
    public function __call($name, $arguments)
    {
        $class = new self();
        if (method_exists($class, $name)) {
            return call_user_func_array([$class, $name], $arguments);
        }

        return null;
    }


    /**
     * Call static method
     *
     * @param $name
     * @param $arguments
     * @return mixed|$this|null
     */
    public static function __callStatic($name, $arguments)
    {
        $class = new self();
        if (method_exists($class, $name)) {
            return call_user_func_array([$class, $name], $arguments);
        }

        return null;
    }


    /**
     * Set method
     *
     * @param string|mixed $name
     * @param string|array $value
     * @return void
     */
    protected function set($name, $value): void
    {
        $this->notation->set($name, $value);
        static::$collection = $this->notation->all();
    }


    /**
     * Add method
     *
     * @param string|mixed $name
     * @param string|array $value
     * @return void
     */
    protected function add($name, $value): void
    {
        $return = $this->notation->add($name, $value);
        static::$collection = $this->notation->all();
    }


    /**
     * Get method
     *
     * @param string $name
     * @return bool|array
     */
    protected function get($name): array
    {
        return $this->has($name) !== false
            ? $this->notation->get($name)
            : $this->has($name);
    }


    /**
     * Check method
     *
     * @param string $name
     * @return bool
     */
    protected function has($name)
    {
        return $this->notation->has($name);
    }


    /**
     * Clear method
     *
     * @param string $name
     * @return bool
     */
    protected function clear($name)
    {
        $return = $this->has($name) !== false
            ? $this->notation->clear($name)
            : $this->has($name);
        static::$collection = $this->notation->all();

        return $return;
    }


    /**
     * Get all data
     *
     * @return array
     */
    protected function all()
    {
        return $this->notation->all();
    }
}