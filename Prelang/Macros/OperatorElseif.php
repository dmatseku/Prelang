<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorElseif extends Macro
{
    public function name(): string
    {
        return 'elseif';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php elseif (".trim($fragment->match[3][0], " \t\n\r\0\x0B'\"")."): ?>";
    }

    public function clean(string &$result): void {}
}