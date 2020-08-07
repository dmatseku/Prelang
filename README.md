# Prelang
Extensible html preprocessor. This library looks for macros in files, replaces them with the appropriate strings and returns clear string of html \ php code.

## Code Example

    /*
     * @view/Layouts/Layout.prelang.php:
     */
    @php
    
    use lib\Base\Support\Config;
    
    @endphp
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>{{ Config::get('app', 'name', 'None') }}</title>
        </head>
        <body>
            @section('content')
        </body>
    </html>



    /*
     * @view/test.prelang.php:
     */
    @use('@view/Layouts/Layout.prelang.php')
    
    @in('content')
        @for ($i = 5; $i >= 0; $i--)
            <h3>{{ $i }}</h3>  
        @endfor
    
        @include('@view/include.php')
    
        @if (true)
            <p>if</p>
        @endif
    
        @if (false)
            <p>if</p>
        @elseif (true)
            <p>elseif</p>
            @endif
    
        @if (false)
            <p>if</p>
        @elseif (false)
            <p>elseif</p>
        @else
            <p>else</p>
        @endif
    @endin

## Structure
The preprocessor has a single macro cannot be disabled or removed: `@use`. This macro is a command to inherit from another file.
Other macros and handlers can be overridden or removed.

So preprocessor has three stages:
- before - the library calls each specified and found macro for the given file, finds `@use` in it, goes to the next file, etc.
- after - the library takes the last page as a result and for each file, together with the result, calls the specified macros.
- finish - the library calls each specified macros for result.

Before doing this, preprocessor creates and saves objects of all handlers, and each handler creates and saves objects of all macros.

## Usage
`Prelang\Prelang` class takes an array as configuration. The basic config file is attached to the project.<br>
Create object of `Prelang\Prelang` in your view. Then take result from `Prelang->process()` function. Finally for printing html code, export input arguments and call `eval("?>".result of processing."<?php")`:

    $prelang = new Prelang\Prelang(require 'prelang.php');
    $result = $prelang->process('@view/test.php');
    export $args;
    eval("?>".$result."<?php");
    
## Config
Keys `Spaces` and `viewDir` are required and must contain arrays. Arrays can be empty.
#### Spaces
This array contains namespaces of custom prelang elements. Example:

    'Spaces' => [
        'app\\Prelang',
    ],
The search for elements inside the preprocessor will be carried out as follows:

    namespace."\\Handlers\\".handler
    namespace."\\Macros\\".macros
The item search order matches the order of the namespaces in the list. Standard macros and handlers have the lowest priority and can be overridden.
#### ViewDirs
This array contains paths to directories containing view files and their aliases. Example:

    'viewDir' => [
       'view' => 'app/Views',
    ],
So in this example, when you pass the file path to preprocessor or macros `@use`, `@include`, it should look like this:

    '@view/relative_path'
#### Handlers
This array contains macro dependencies to handlers. Example:

    'handlers' => [
        'BaseFull' => [
            'Code',
        ],
    ],
The dependence is composed as follows:

    'Handler class name' => [macros1, macros2, ...]
You can pass parameters to macros:
    
    'handler class name' => [
        macros1 => ['hello'],
        macros2,
        ...
    ]
These parameters you will see in the constructor of `macros1`.
#### Before, After, Finish
These arrays determine which macros and in what order will be called. Example:

    'finish' => [
        'BaseFull' => ['Code'],
        'BaseFullParam' => [
            'Error',
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
    ],
These arrays support nesting. So if you need to call macros of the same handler in different places, you can do the following:

    'finish' => [
        ['BaseFullParam' => 'Error']
        'BaseFull' => ['Code'],
        'BaseFullParam' => [
            'OperatorIf',
            'OperatorForeach',
            'OperatorFor',
            'OperatorWhile',
        ],
    ],
## Standard macros
Here is a list of standard macros:

### To be continued...