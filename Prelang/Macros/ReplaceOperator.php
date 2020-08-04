<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macros;

abstract class ReplaceOperator extends Macros
{
    abstract protected static function  open(Fragment $fragment): string;
    abstract protected static function  close(Fragment $fragment): string;

    public function                     before(Fragment $fragment) {return null;}

    public function                     after(Fragment $fragment) {return null;}

    public function                     finish(Fragment $fragment)
    {
        $openReplace = static::open($fragment);
        $closeReplace = static::close($fragment);

        return $openReplace.$fragment->match[4][0].$closeReplace;
    }

    public function                     clean(Fragment $fragment): void {}
}