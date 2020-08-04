<?php


namespace Prelang\Handlers;


class BaseFull extends Base
{
    public function __construct(&$args, &$macrosArray, $appSpace)
    {
        parent::__construct($args, $macrosArray, $appSpace);

        $this->with(self::CONTENT);
    }
}