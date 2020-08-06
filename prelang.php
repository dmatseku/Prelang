<?php

return [
    'Spaces' => [
        'app\\Prelang',
    ],
    'viewDir' => [
       'view' => 'app/Views',
    ],
    'handlers' => [
        'Base' => [
            'OperatorElse',
        ],
        'BaseCut' => [
            'Inc',
            'OperatorElseif',
        ],
        'BaseFull' => [
            'Code',
        ],
        'BaseFullParam' => [
            'Error',
            'In',
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
        'Out' => [
            'Special',
            'Simple',
        ],
    ],
    'before' => [
        'BaseCut' => ['Inc'],
    ],
    'after' => [
        'BaseFullParam' => ['In'],
    ],
    'finish' => [
        'BaseFull' => ['Code'],
        'BaseFullParam' => [
            'Error',
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
        'BaseCut' => ['OperatorElseif'],
        'Base' => ['OperatorElse'],
        'Out' => ['Special', 'Simple'],
    ],
];
