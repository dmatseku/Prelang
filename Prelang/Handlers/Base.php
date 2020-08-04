<?php


namespace Prelang\Handlers;


use Prelang\Handler;

class Base extends Handler
{

    protected function macrosBegin($macrosName)
    {
        return "@$macrosName";
    }

    protected function macrosEnd($macrosName)
    {
        return "@end$macrosName";
    }
}