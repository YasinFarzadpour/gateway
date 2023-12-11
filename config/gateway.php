<?php

return [

    //-------------------------------
    // Timezone for insert dates in database
    // If you want Gateway not set timezone, just leave it empty
    //--------------------------------
    'timezone' => 'Asia/Tehran',

    //--------------------------------
    // Gateway Ids
    //--------------------------------

    'gateway_ids' => [
        'zarinpal'     => 1,
        'mellat'       => 2,
        'saman'        => 3,
        'payir'        => 4,
        'irankish'     => 5,
        'sadad'        => 6,
        'parsian'      => 7,
        'pasargad'     => 8,
        'asanpardakht' => 9,
        'paypal'       => 10
    ],

    //-------------------------------
    // Tables names
    //--------------------------------
    'table-transactions' => 'gateway_transactions',
    'table-gateway-users' => 'gateway_users',
];
