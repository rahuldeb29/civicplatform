<?php

return [

   'default' => 'main',

'connections' => [

    'main' => [
        'salt' => env('APP_KEY'),
        'length' => 10,
        'alphabet' => 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    ],

],

];
