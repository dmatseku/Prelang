<?php


namespace Prelang\Handlers;


class BaseFullParam extends Base
{
    public function __construct()
    {
        $this->with(self::PARAMS|self::CONTENT);
    }
}