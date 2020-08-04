<?php


namespace Prelang\Macros;


use Prelang\Fragment;

class OperatorWhile extends ReplaceOperator
{
    public function             name(): string
    {
        return 'while';
    }

    protected static function   open(Fragment $fragment): string
    {
        return '<?php while ('.trim($fragment->match[3][0], " \t\n\r\0\x0B'\"").'): ?>';
    }

    protected static function   close(Fragment $fragment): string
    {
        return '<?php endwhile; ?>';
    }
}