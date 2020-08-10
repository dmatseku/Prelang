<?php


namespace   Prelang\Handler;

use Prelang\Fragment;
use Prelang\Macro\Macro;

abstract class  Handler
{
    public const    PARAMS = 1;
    public const    CONTENT = 2;

    private int     $modules = 0;

    abstract protected function macrosBegin(string $macrosName): string;
    abstract protected function macrosEnd(string $macrosName): string;

    protected function          has(int $module): bool
    {
        return ($this->modules & $module) > 0;
    }

    protected function          with(int $module): void
    {
        $this->modules |= $module;
    }

    private static function     replace(string &$string, ?string $replacement, array $fullMatch, int &$offset): void
    {
        $position = $fullMatch[1];
        $substr = $fullMatch[0];
        $substrlen = strlen($fullMatch[0]);

        if (is_string($replacement) && substr($string, $position, $substrlen) === $substr) {
            $string = substr_replace($string, $replacement, $position, $substrlen);
        } else {
            $offset = $position + $substrlen;
        }
    }

    public function             handle(Fragment $fragment, Macro $macro, string $partName): void
    {
        $match = new MacrosMatch($this->modules);
        $offset = 0;

        while ($fragment->match = $match->match($fragment->page, $this->macrosBegin($macro->name()),
            $this->macrosEnd($macro->name()), $offset)) {
            $partResult = $macro->$partName($fragment);
            self::replace($fragment->page, $partResult, $fragment->match[0], $offset);
        }

        $offset = 0;

        while ($fragment->match = $match->match($fragment->result, $this->macrosBegin($macro->name()),
            $this->macrosEnd($macro->name()), $offset)) {
            $partResult = $macro->$partName($fragment);
            self::replace($fragment->result, $partResult, $fragment->match[0], $offset);
        }
    }

    public function             clean(string &$result, string $macroName): void
    {
        $match = new MacrosMatch($this->modules);

        while ($matchResult = $match->match($result, $this->macrosBegin($macroName), $this->macrosEnd($macroName))) {
            $result = preg_replace("/".preg_quote($matchResult[0][0], null)."/", '', $result);

            if ($result === null) {
                throw new \RuntimeException('Regex error', 500);
            }
        }
    }
}