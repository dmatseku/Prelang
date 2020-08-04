<?php


namespace Prelang\Macros;


use Prelang\Fragment;

class OperatorFor extends ReplaceOperator
{
    public function name(): string
    {
        return 'for';
    }

    protected static function open(Fragment $fragment): string
    {
        return '<?php for ('.trim($fragment->match[3][0], " \t\n\r\0\x0B'\"").'): ?>';
    }

    protected static function close(Fragment $fragment): string
    {
        return '<?php endfor; ?>';
    }
}