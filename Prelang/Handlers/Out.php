<?php


namespace Prelang\Handlers;


use Prelang\Handler;

class Out extends Handler
{
    public function __construct(&$macrosArray, $appSpace)
    {
        parent::__construct($macrosArray, $appSpace);

        $this->with(self::CONTENT);
    }

    protected function macrosBegin($macrosName)
    {
        return '{'.$macrosName;
    }

    protected function macrosEnd($macrosName)
    {
        if ($macrosName === '{') {
            $macrosName = '}';
        }
        return $macrosName.'}';
    }
}