<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macros;

class InsertVariable extends Macros
{

    public function name(): string
    {
        return '';
    }

    public function before(Fragment $fragment) {return null;}

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment)
    {
        $var = trim($fragment->match[3][0], " \t\n\r\0\x0B'");

        return '$this->'.$var;
    }

    public function clean(Fragment $fragment): void {}
}