<?php


namespace   Prelang;


trait   ViewArgs
{
    protected $args = [];

    public function __set($name, $value)
    {
        $this->args[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->args[$name])) {
            return $this->args[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Неопределенное свойство в __get(): ' . $name .
            ' в файле ' . $trace[0]['file'] .
            ' на строке ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    public function __isset($name)
    {
        return isset($this->args[$name]);
    }

    public function __unset($name)
    {
        unset($this->args[$name]);
    }
}