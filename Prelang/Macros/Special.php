<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class Special extends Macro
{
    public function name(): string
    {
        return '{';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string {return null;}

    public function finish(Fragment $fragment): ?string
    {
        return '<?= htmlspecialchars('.$fragment->match[4][0].') ?>';
    }

    public function clean(string &$result): void {}
}