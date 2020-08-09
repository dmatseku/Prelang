<?php


namespace Prelang\Handler;


class HandlerFactory
{
    public static function  createArray(array $handlersArray, array $spaces): array
    {
        $result = [];

        foreach ($handlersArray as $handler) {
            if (!is_string($handler)) {
                throw new \RuntimeException('Invalid config in handlers array', 500);
            }
            $result[$handler] = self::create($handler, $spaces);
        }
        return $result;
    }

    public static function  create(string $handler, array &$spaces): Handler
    {
        foreach ($spaces as $space) {
            $handlerClass = $space.'\\Handlers\\'.$handler;

            if (class_exists($handlerClass) && is_subclass_of($handlerClass, Handler::class)) {
                return new $handlerClass();
            }
        }
        throw new \RuntimeException('Handler "'.$handler.'" of prelang does not exists', 500);
    }
}