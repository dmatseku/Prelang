<?php


namespace   Prelang;


use SplDoublyLinkedList;

class   Prelang
{
    private static array    $dirs = [];
    private array           $handlers = [];
    private array           $orderBefore = [];
    private array           $orderAfter = [];
    private array           $orderFinish = [];

    public function         __construct($config)
    {
        if (isset($config['handlers'])) {
            $this->handlers = Handler::createArray($config['handlers'], array_merge($config['spaces'], ['Prelang']));
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

    public static function  getPage($pageName)
    {
        if ($pageName !== false) {
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
        return false;
    }

    public function         process($view)
    {
        $pageList = $this->before($view);
        $result = $pageList->isEmpty() ? '' : $pageList->pop();
        $this->after($result, $pageList);
        $this->finish($result);

        return $result;
    }

    private function        before($view)
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
                $view = false;
            }
        }

        return $pageList;
    }

    private function        after(&$result, $pageList)
    {
        while (!$pageList->isEmpty()) {
            $page = $pageList->pop();
            $this->goOrder($this->orderAfter, $result, $page, 'after');
        }
    }

    private function        finish(&$result)
    {
        $this->goOrder($this->orderFinish, $result, $result, 'finish');

        preg_replace('/@use\s*\(\s*[\'\"]?\s*([\w\/ @.]*)\s*[\'\"]?\s*\)/', '', $result);
        foreach ($this->handlers as $handler) {
            $handler->clean($result);
        }
    }

    private function        goOrder(&$order, &$result, &$page, $action) {
        foreach ($order as $handler => $macros) {
            if (!is_string($handler)) {
                $this->goOrder($macros, $result, $page, $action);
            } else {
                $handler = $this->handlers[$handler];
                $handler->process($result, $page, $macros, $action);
            }
        }
    }
}