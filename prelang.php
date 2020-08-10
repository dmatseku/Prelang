<?php

return [
    'spaces' => [
        'app\\Prelang',
    ],
    'viewDir' => [
       'view' => 'app/Views',
    ],
    'handlers' => [
        'Base',
        'BaseCut',
        'BaseFull',
        'BaseFullParam',
        'Out',
    ],
    'macros' => [
        'Define' => ['BaseFullParam'],
        'Inc' => ['BaseCut'],
        'In' => ['BaseFullParam'],
        'Code' => ['BaseFull'],
        'OperatorIf' => ['BaseFullParam'],
        'OperatorElse' => ['Base'],
        'OperatorElseif' => ['BaseCut'],
        'OperatorWhile' => ['BaseFullParam'],
        'OperatorFor' => ['BaseFullParam'],
        'OperatorForeach' => ['BaseFullParam'],
        'OperatorSwitch' => ['BaseFullParam'],
        'OperatorCase' => ['BaseCut'],
        'OperatorDefault' => ['Base'],
        'OperatorBreak' => ['Base'],
        'OperatorContinue' => ['Base'],
        'Special' => ['Out'],
        'Simple' => ['Out'],
    ],
    'before' => [
        'Inc',
        'Define',
    ],
    'after' => [
        'In',
    ],
    'finish' => [
        'Code',
        'OperatorIf',
        'OperatorElseif',
        'OperatorElse',
        'OperatorSwitch',
        'OperatorCase',
        'OperatorDefault',
        'OperatorForeach',
        'OperatorFor',
        'OperatorWhile',
        'OperatorBreak',
        'OperatorContinue',
        'Special',
        'Simple',
    ],
];
