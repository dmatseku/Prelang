<?php


namespace Prelang\Macros;


use Prelang\Fragment;
use Prelang\Macro\Macro;

class In extends Macro
{
    public function name(): string
    {
        return 'in';
    }

    public function before(Fragment $fragment): ?string {return null;}

    public function after(Fragment $fragment): ?string
    {
        $contentNames = explode(',', trim($fragment->match[3][0], " \t\n\r\0\x0B'\""));

        foreach ($contentNames as $name) {
            $name = trim($name, " \t\n\r\0\x0B'\"");

            preg_match_all("/@section\s*\(\s*['\"]?\s*$name\s*['\"]?\s*\)/", $fragment->result, $matches,
                PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
            foreach ($matches as $match) {
                $fragment->result = substr_replace($fragment->result, $fragment->match[4][0],
                                                    $match[0][1], strlen($match[0][0]));
            }
        }

        return null;
    }

    public function finish(Fragment $fragment): ?string {return null;}

    public function clean(string &$result): void
    {
        $result = preg_replace("/@section\s*\(\s*'?\s*([\w\/]\s*)*'?\s*\)/", '', $result);
    }
}