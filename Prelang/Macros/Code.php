<?php


namespace Prelang\Macros;


use Prelang\Fragment;

class Code extends ReplaceOperator
{
    public function name(): string
    {
        return 'php';
    }

    protected static function open(Fragment $fragment): string
    {
        return '<?php ';
    }

    protected static function close(Fragment $fragment): string
    {
        return ' ?>';
    }
}