<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;
use Prelang\Prelang;

class Inc extends Macro
{
    public function name(): string
    {
        return 'include';
    }

    public function before(Fragment $fragment): ?string
    {
        $file = Prelang::getPage(trim($fragment->match[3][0], " \t\n\r\0\x0B'"));
        if (!$file) {
            $file = '';
        }

        return $file;
    }

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string {return null;}

    public function clean(string &$result): void {}
}