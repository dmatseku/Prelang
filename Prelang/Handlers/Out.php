<?php


namespace Prelang\Handlers;


use Prelang\Handler\Handler;

class Out extends Handler
{
    public function __construct()
    {
        $this->with(self::CONTENT);
    }

    protected function macrosBegin(string $macrosName): string
    {
        return '{'.$macrosName;
    }

    protected function macrosEnd(string $macrosName): string
    {
        if ($macrosName === '{') {
            $macrosName = '}';
        }
        return $macrosName.'}';
    }
}