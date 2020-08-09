<?php


namespace Prelang\Macro;


use Prelang\Handler;

class MacroFactory
{
    public static function  createArray(array $macrosArray, array $spaces): array
    {
        $result = [];

        foreach ($macrosArray as $macro => $handlers) {
            if (!is_string($macro) || !is_array($handlers)) {
                throw new \RuntimeException('Invalid config in macros array', 500);
            }
            $result[$macro] = self::create($macro, $handlers, $spaces);
        }
        return $result;
    }

    public static function  create(string $macro, array $handlers, array &$spaces): Macro
    {
        foreach ($spaces as $space) {
            $macrosClass = $space.'\\Macros\\'.$macro;

            if (class_exists($macrosClass) && is_subclass_of($macrosClass, Macro::class)) {
                return new $macrosClass($handlers);
            }
        }
        throw new \RuntimeException('Macros "'.$macro.'" of prelang does not exists', 500);
    }
}