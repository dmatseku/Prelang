<?php

namespace Prelang\Macros;

use Prelang\Fragment;
use Prelang\Macro;
use Prelang\MacrosMatch;

class Define extends Macro
{
    private array   $defined = [];

    public function         name(): string
    {
        return 'define';
    }

    public function         before(Fragment $fragment)
    {
        $args = explode(',', trim($fragment->match[3][0], " \t\n\r\0\x0B'\""));

        if (!empty($args)) {
            $key = trim($args[0], " \t\n\r\0\x0B'\"");

            $this->defined[$key] = [];
            $this->defined[$key]['params'] = [];
            $this->defined[$key]['content'] = trim($fragment->match[4][0]);

            foreach ($args as $i => $arg) {
                if ($i < 1) {
                    continue;
                }

                $this->defined[$key]['params'][] = trim($arg, " \t\n\r\0\x0B'\"");
            }
        }

        return '';
    }

    public function         after(Fragment $fragment) {}

    public function         finish(Fragment $fragment) {}

    public function         clean(Fragment $fragment): void {
        foreach ($this->defined as $macro => $data) {
            if (!empty($data['params'])) {
                self::replaceParams($fragment->result, $macro, $data['content'], $data['params']);
            } else {
                $fragment->result = preg_replace("/\W".$macro."\W/", $data['content'], $fragment->result);
            }
        }
    }

    private static function replaceParams(string &$result, string $macro, string $content, array $params): void
    {
        $match = new MacrosMatch(1);
        $matchResult = null;

        while ($matchResult = $match->match($result, $macro, '')) {
            $paramsValues = explode(',', trim($matchResult[3][0], " \t\n\r\0\x0B\"'"));
            $insertion = $content;

            if (count($paramsValues) >= count($params)) {
                foreach ($params as $key => $param) {
                    $insertion = preg_replace("/:$param/", $paramsValues[$key], $insertion);
                }

                $result = substr_replace($result, $insertion, $matchResult[0][1], strlen($matchResult[0][0]));
            } else {
                $result = preg_replace("/".$matchResult[0][0]."/", '', $result);
            }
        }
    }
}