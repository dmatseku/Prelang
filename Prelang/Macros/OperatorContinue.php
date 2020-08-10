<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorContinue extends Macro
{
    public function name(): string
    {
        return 'continue';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php continue; ?>";
    }

    public function clean(string &$result): void {}
}