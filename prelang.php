<?php

return [
    'spaces' => [
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
            'Define',
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
        'BaseFullParam' => ['Define'],
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
