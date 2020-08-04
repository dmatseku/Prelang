<?php


namespace Prelang\Handlers;


class BaseFullParam extends Base
{
    public function __construct(&$args, &$macrosArray, $appSpace)
    {
        parent::__construct($args, $macrosArray, $appSpace);

        $this->with(self::PARAMS|self::CONTENT);
    }
}