<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorBreak extends Macro
{
    public function name(): string
    {
        return 'break';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php break; ?>";
    }

    public function clean(string &$result): void {}
}