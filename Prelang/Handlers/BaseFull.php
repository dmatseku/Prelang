<?php


namespace Prelang\Handlers;


class BaseFull extends Base
{
    public function __construct()
    {
        $this->with(self::CONTENT);
    }
}