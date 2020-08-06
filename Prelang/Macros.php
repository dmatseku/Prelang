<?php


namespace   Prelang;


abstract class  Macros
{
    abstract public function    name(): string;
    abstract public function    before(Fragment $fragment);
    abstract public function    after(Fragment $fragment);
    abstract public function    finish(Fragment $fragment);
    abstract public function    clean(Fragment $fragment): void;

    public function             __construct($params)
    {}

    public static function      createArray(&$macrosArray, array $spaces)
    {
        $result = [];

        foreach ($macrosArray as $key => $value) {
            $macros = $value;
            $params = [];
            $found = false;
            if (is_string($key)) {
                $macros = $key;
                $params = $value;
            }

            foreach ($spaces as $space) {
                $macrosClass = $space.'\\Macros\\'.$macros;

                if (class_exists($macrosClass) && is_subclass_of($macrosClass, self::class)) {
                    $result[$macros] = new $macrosClass($params);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                throw new \RuntimeException('Macros "'.$macros.'" of prelang does not exists', 500);
            }
        }

        return $result;
    }
}