<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro;

class Simple extends Macro
{
    public function name(): string
    {
        return '!!';
    }

    public function before(Fragment $fragment) {return null;}

    public function after(Fragment $fragment) {return null;}

    public function finish(Fragment $fragment)
    {
        return '<?= '.$fragment->match[4][0].' ?>';
    }

    public function clean(Fragment $fragment): void {}
}