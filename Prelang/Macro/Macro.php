<?php


namespace   Prelang\Macro;


use Prelang\Fragment;

abstract class  Macro
{
    protected array             $handlers = [];

    abstract public function    name(): string;
    abstract public function    before(Fragment $fragment): ?string;
    abstract public function    after(Fragment $fragment): ?string;
    abstract public function    finish(Fragment $fragment): ?string;
    abstract public function    clean(string &$result): void;

    public function             __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function             handle(Fragment $fragment, array &$handlers, string $partName)
    {
        foreach ($this->handlers as $handler) {
            if (isset($handlers[$handler])) {
                $handlers[$handler]->handle($fragment, $this, $partName);
            }
        }
    }

    public function             cleanHandle(string &$result, array &$handlers)
    {
        foreach ($this->handlers as $handler) {
            $handlers[$handler]->clean($result, $this->name());
        }

        $this->clean($result);
    }
}