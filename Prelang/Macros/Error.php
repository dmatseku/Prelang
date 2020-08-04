<?php


namespace Prelang\Macros;


use Prelang\Fragment;

class Error extends ReplaceOperator
{
    public function name(): string
    {
        return 'error';
    }

    protected static function open(Fragment $fragment): string
    {
        $param = trim($fragment->match[3][0], " \t\n\r\0\x0B'\"");
        return '<?php if (isset($this->inputErrors) && isset($this->inputErrors[\''.$param.'\'])):'.
                    '$this->error = $this->inputErrors[\''.$param.'\']; ?>';
    }

    protected static function close(Fragment $fragment): string
    {
        return '<?php endif; ?>';
    }
}