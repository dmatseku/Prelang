<?php


namespace Prelang\Handlers;


class BaseCut extends Base
{
    public function __construct(&$args, &$macrosArray, $appSpace)
    {
        parent::__construct($args, $macrosArray, $appSpace);

        $this->with(self::PARAMS);
    }
}