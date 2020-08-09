<?php


namespace Prelang\Handlers;


class BaseCut extends Base
{
    public function __construct()
    {
        $this->with(self::PARAMS);
    }
}