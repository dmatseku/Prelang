<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorElse extends Macro
{
    public function name(): string
    {
        return 'else';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php else: ?>";
    }

    public function clean(string &$result): void {}
}