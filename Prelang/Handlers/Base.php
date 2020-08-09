<?php


namespace Prelang\Handlers;


use Prelang\Handler\Handler;

class Base extends Handler
{

    protected function macrosBegin(string $macrosName): string
    {
        return "@$macrosName";
    }

    protected function macrosEnd(string $macrosName): string
    {
        return "@end$macrosName";
    }
}