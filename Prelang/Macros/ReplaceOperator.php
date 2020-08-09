<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

abstract class ReplaceOperator extends Macro
{
    abstract protected static function  open(Fragment $fragment): string;
    abstract protected static function  close(Fragment $fragment): string;

    public function                     before(Fragment $fragment): ?string {return null;}

    public function                     after(Fragment $fragment): ?string {return null;}

    public function                     finish(Fragment $fragment): ?string
    {
        $openReplace = static::open($fragment);
        $closeReplace = static::close($fragment);

        return $openReplace.$fragment->match[4][0].$closeReplace;
    }

    public function                     clean(string &$result): void {}
}