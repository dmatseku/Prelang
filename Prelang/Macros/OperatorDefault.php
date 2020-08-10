<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorDefault extends Macro
{
    public function name(): string
    {
        return 'default';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php default: ?>";
    }

    public function clean(string &$result): void {}
}