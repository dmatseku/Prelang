<?php


namespace Prelang;


class MacrosMatch
{
    private array   $modules = [false, false];

    public function             __construct(array $modules)
    {
        if (count($modules) >= 2) {
            $this->modules = $modules;
        }
    }

    private static function     getBlockSize(&$code, $offset, $open = '(', $close = ')')
    {
        $block = 1;
        $openLength = strlen($open);
        $closeLength = strlen($close);
        $pattern = "/(".preg_quote($open, null).")|(".preg_quote($close, null).")/";
        $start = $offset;

        while ($block && preg_match($pattern, $code, $matches, PREG_UNMATCHED_AS_NULL|PREG_OFFSET_CAPTURE, $offset)) {
            if ($matches[1][0] !== null) {
                $block++;
                $offset = $matches[1][1] + $openLength;
            } else {
                $block--;
                $offset = $matches[2][1] + $closeLength;
            }
        }
        return $offset - $start - $closeLength;
    }

    private function            getStart(&$code, $beginString, $offset, &$length) {
        if ($this->modules[0]) {
            $pattern = "(".preg_quote($beginString, null).")(\s*)\(";
        } else {
            $pattern = "(".preg_quote($beginString, null).")()";
        }
        if (preg_match("/$pattern/", $code, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $length = $matches[0][1] + strlen($matches[1][0]) + strlen($matches[2][0]);
            return $pattern;
        }
        return false;
    }

    private function            getParams(&$code, &$length, &$pattern) {
        if ($this->modules[0]) {
            $length++;
            $blockLength = self::getBlockSize($code, $length);
            $pattern .= '([\s\S]{'.$blockLength.'})\)';
            $length += $blockLength + 1;
        } else {
            $pattern .= "()";
        }
    }

    private function            getContent(&$code, &$length, &$pattern, $beginString, $endString) {
        if ($this->modules[1]) {
            $pattern .= '([\s\S]{'.self::getBlockSize($code, $length, $beginString, $endString).'})';
        } else {
            $pattern .= "()";
        }
    }

    private function            getFinish(&$pattern, $endString) {
        if ($this->modules[1]) {
            $pattern .= '('.preg_quote($endString, null).')';
        } else {
            $pattern .= "()";
        }
    }

    public function             match(&$code, $beginString, $endString, $offset = 0)
    {
        $length = 0;

        if ($pattern = $this->getStart($code, $beginString, $offset, $length)) {
            $this->getParams($code, $length, $pattern);
            $this->getContent($code, $length, $pattern, $beginString, $endString);
            $this->getFinish($pattern, $endString);

            if (preg_match("/$pattern/", $code, $result, PREG_OFFSET_CAPTURE, $offset)) {
                return $result;
            }
        }
        return null;
    }
}