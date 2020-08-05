<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macros;
use Prelang\Prelang;

class Inc extends Macros
{
    public function name(): string
    {
        return 'include';
    }

    public function before(Fragment $fragment)
    {
        $file = Prelang::getPage(trim($fragment->match[3][0], " \t\n\r\0\x0B'"));
        if (!$file) {
            $file = '';
        }

        return $file;
    }

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment) {return null;}

    public function clean(Fragment $fragment): void {}
}