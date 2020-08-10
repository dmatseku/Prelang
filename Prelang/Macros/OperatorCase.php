<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class OperatorCase extends Macro
{
    public function name(): string
    {
        return 'case';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return "<?php case ".$fragment->match[3][0].": ?>";
    }

    public function clean(string &$result): void {}
}