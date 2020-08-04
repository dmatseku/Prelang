<?php


namespace   Prelang;


abstract class  Macros
{
    use ViewArgs;

    abstract public function    name(): string;
    abstract public function    before(Fragment $fragment);
    abstract public function    after(Fragment $fragment);
    abstract public function    finish(Fragment $fragment);
    abstract public function    clean(Fragment $fragment): void;

    public function             __construct(&$args, $params)
    {
        if (is_array($args)) {
            $this->args = &$args;
        }
    }

    public static function      createArray(&$args, &$macrosArray, $appSpace)
    {
        $result = [];

        foreach ($macrosArray as $key => $value) {
            $macros = $value;
            $params = [];
            if (is_string($key)) {
                $macros = $key;
                $params = $value;
            }

            $macrosClass = $appSpace.'\\Macros\\'.$macros;
            if (!class_exists($macrosClass) || !is_subclass_of($macrosClass, self::class)) {
                $macrosClass = 'Prelang\\Macros\\'.$macros;
                if (!class_exists($macrosClass) || !is_subclass_of($macrosClass, self::class)) {
                    throw new \RuntimeException('Macros "'.$macros.'" of prelang does not exists', 500);
                }
            }

            $result[$macros] = new $macrosClass($args, $params);
        }

        return $result;
    }
}