<?php


namespace   Prelang;

abstract class  Handler
{
    use ViewArgs;

    public const    PARAMS = 1;
    public const    CONTENT = 2;

    private array   $macros = [];
    private int     $modules = 0;

    abstract protected function macrosBegin($macrosName);
    abstract protected function macrosEnd($macrosName);

    public function             __construct(&$args, &$macrosArray, $appSpace)
    {
        if (is_array($args)) {
            $this->args = &$args;
        }

        if (is_array($macrosArray)) {
            $this->macros = Macros::createArray($args, $macrosArray, $appSpace);
        }
    }

    public static function      createArray(&$args, &$handlers, $appSpace)
    {
        $result = [];

        foreach ($handlers as $handler => $macros) {
            $handlerClass = $appSpace.'\\Handlers\\'.$handler;
            if (!class_exists($handlerClass)) {
                $handlerClass = 'Prelang\\Handlers\\'.$handler;
                if (!class_exists($handlerClass)) {
                    throw new \RuntimeException('Handler "'.$handler.'" of prelang does not exists', 500);
                }
            }

            $result[$handler] = new $handlerClass($args, $macros, $appSpace);
        }

        return $result;
    }

    protected function          has($module)
    {
        return ($this->modules & $module) > 0;
    }

    protected function          with($module)
    {
        $this->modules |= $module;
    }

    private static function     replace(&$string, $replacement, array $fullMatch)
    {
        $position = $fullMatch[1];
        $substr = $fullMatch[0];
        $substrlen = strlen($fullMatch[0]);

        if (is_string($replacement) && substr($string, $position, $substrlen) === $substr) {
            $string = substr_replace($string, $replacement, $position, $substrlen);
            $offset = 0;
        } else {
            $offset = $position + $substrlen;
        }
        return $offset;
    }

    public function             process(&$result, &$page, $macrosArray, $partName)
    {
        $match = new MacrosMatch([$this->has(self::PARAMS), $this->has(self::CONTENT)]);
        $fragment = new Fragment();
        $fragment->result = &$result;
        $fragment->page = &$page;

        foreach ($macrosArray as $macros) {
            $macros = $this->macros[$macros];
            $offset = 0;

            while ($fragment->match = $match->match($fragment->page, $this->macrosBegin($macros->name()),
                                                    $this->macrosEnd($macros->name()), $offset)) {
                $partResult = $macros->$partName($fragment);
                $offset = self::replace($fragment->page, $partResult, $fragment->match[0]);
            }
            while ($fragment->match = $match->match($fragment->result, $this->macrosBegin($macros->name()),
                                                    $this->macrosEnd($macros->name()), $offset)) {
                $partResult = $macros->$partName($fragment);
                $offset = self::replace($fragment->result, $partResult, $fragment->match[0]);
            }
        }
    }

    public function             clean(&$result)
    {
        $match = new MacrosMatch([$this->has(self::PARAMS), $this->has(self::CONTENT)]);
        $fragment = new Fragment();
        $fragment->result = &$result;

        foreach ($this->macros as $macros) {
            $name = $macros->name();

            while ($fragment->match = $match->match($result, $this->macrosBegin($name), $this->macrosEnd($name))) {
                $result = preg_replace("/".preg_quote($fragment->match[0][0], null)."/", '', $result);
                if ($result === null) {
                    throw new \RuntimeException('Regex error', 500);
                }
            }
            $macros->clean($fragment);
        }
    }
}