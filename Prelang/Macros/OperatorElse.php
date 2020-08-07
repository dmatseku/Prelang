<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro;

class OperatorElse extends Macro
{
    public function name(): string
    {
        return 'else';
    }

    public function before(Fragment $fragment) {return null;}

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment)
    {
        return "<?php else: ?>";
    }

    public function clean(Fragment $fragment): void {}
}