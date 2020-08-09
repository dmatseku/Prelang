<?php


namespace Prelang\Handler;


class MacrosMatch
{
    private int $modules;

    public function             __construct(int $modules)
    {
        $this->modules = $modules;
    }

    private static function getBlockSize(string &$code, int $offset, string $open = '(', string $close = ')'): int
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

    private function        getStart(string &$code, string $beginString, int $offset, int &$length)
    {
        if ($this->modules & 1) {
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

    private function        getParams(string &$code, int &$length, string &$pattern): void
    {
        if ($this->modules & 1) {
            $length++;
            $blockLength = self::getBlockSize($code, $length);
            $pattern .= '([\s\S]{'.$blockLength.'})\)';
            $length += $blockLength + 1;
        } else {
            $pattern .= "()";
        }
    }

    private function        getContent(string &$code, int &$length, string &$pattern, string $beginString, string $endString): void
    {
        if ($this->modules & 2) {
            $pattern .= '([\s\S]{'.self::getBlockSize($code, $length, $beginString, $endString).'})';
        } else {
            $pattern .= "()";
        }
    }

    private function        getFinish(string &$pattern, string $endString) {
        if ($this->modules & 2) {
            $pattern .= '('.preg_quote($endString, null).')';
        } else {
            $pattern .= "()";
        }
    }

    /**
     * @param string $code
     * @param string $beginString
     * @param string $endString
     * @param int $offset
     * @return array|null
     */
    public function         match(string &$code, string $beginString, string $endString, int $offset = 0): ?array
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