<?php


namespace   Prelang;


use Prelang\Handler\HandlerFactory;
use Prelang\Macro\MacroFactory;
use SplDoublyLinkedList;

class   Prelang
{
    private static array    $dirs = [];
    private array           $handlers = [];
    private array           $macros = [];
    private array           $orderBefore = [];
    private array           $orderAfter = [];
    private array           $orderFinish = [];

    public function         __construct(array $config)
    {
        $spaces = [];
        if (isset($config['spaces'])) {
            $spaces = array_merge($config['spaces'], ['Prelang']);
        }

        if (isset($config['handlers'])) {
            $this->handlers = HandlerFactory::createArray($config['handlers'], $spaces);
        }
        if (isset($config['macros'])) {
            $this->macros = MacroFactory::createArray($config['macros'], $spaces);
        }

        if (isset($config['before'])) {
            $this->orderBefore = $config['before'];
        }
        if (isset($config['after'])) {
            $this->orderAfter = $config['after'];
        }
        if (isset($config['finish'])) {
            $this->orderFinish = $config['finish'];
        }

        if (isset($config['viewDir'])) {
            self::$dirs = $config['viewDir'];
        }
    }

    public static function  getPage(string $pageName): string
    {
        foreach (self::$dirs as $mask => $path) {
            $pattern = preg_quote('@'.$mask, null);
            $page = preg_replace("/$pattern/", $path, $pageName);

            if (file_exists($page) && is_file($page)) {
                ob_start();
                require $page;
                return ob_get_clean();
            }
        }
        throw new \RuntimeException('View not found', 500);
    }

    public function         process(string $view): string
    {
        $pageList = $this->before($view);
        $result = $pageList->isEmpty() ? '' : $pageList->pop();
        $this->after($result, $pageList);
        $this->finish($result);

        return $result;
    }

    private function        before(string $view): SplDoublyLinkedList
    {
        $pageList = new SplDoublyLinkedList();
        $views = [];

        while ($page = self::getPage($view)) {
            $this->goOrder($this->orderBefore, $page, $page, 'before');
            $pageList->push($page);

            if (preg_match('/@use\s*\(\s*[\'\"]?\s*([\w\/ @.]+)\s*[\'\"]?\s*\)/', $page, $matches) &&
                    !isset($views[$matches[1]])) {
                $view = $matches[1];
                $views[$matches[1]] = 1;
            } else {
                break;
            }
        }

        return $pageList;
    }

    private function        after(string &$result, SplDoublyLinkedList $pageList): void
    {
        while (!$pageList->isEmpty()) {
            $page = $pageList->pop();
            $this->goOrder($this->orderAfter, $result, $page, 'after');
        }
    }

    private function        finish(string &$result): void
    {
        $this->goOrder($this->orderFinish, $result, $result, 'finish');

        preg_replace('/@use\s*\(\s*[\'\"]?\s*([\w\/ @.]*)\s*[\'\"]?\s*\)/', '', $result);
        foreach ($this->macros as $macro) {
            $macro->cleanHandle($result, $this->handlers);
        }
    }

    private function        goOrder(array &$order, string  &$result, string &$page, string $action): void
    {
        $fragment = new Fragment();
        $fragment->page = &$page;
        $fragment->result = &$result;

        foreach ($order as $macro) {
            $this->macros[$macro]->handle($fragment, $this->handlers, $action);
        }
    }
}