<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macros;

class Special extends Macros
{
    public function name(): string
    {
        return '{';
    }

    public function before(Fragment $fragment) {return null;}

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment)
    {
        return '<?= htmlspecialchars('.$fragment->match[4][0].') ?>';
    }

    public function clean(Fragment $fragment): void {}
}