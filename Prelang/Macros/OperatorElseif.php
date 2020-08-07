<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro;

class OperatorElseif extends Macro
{
    public function name(): string
    {
        return 'elseif';
    }

    public function before(Fragment $fragment) {return null;}

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment)
    {
        return "<?php elseif (".trim($fragment->match[3][0], " \t\n\r\0\x0B'\"")."): ?>";
    }

    public function clean(Fragment $fragment): void {}
}