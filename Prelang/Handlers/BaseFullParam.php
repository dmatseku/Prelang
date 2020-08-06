<?php


namespace Prelang\Handlers;


class BaseFullParam extends Base
{
    public function __construct(&$macrosArray, $appSpace)
    {
        parent::__construct($macrosArray, $appSpace);

        $this->with(self::PARAMS|self::CONTENT);
    }
}