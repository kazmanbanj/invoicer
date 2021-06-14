<?php

return [
    'footer_text' => env('Invoice must be paid within 30 days'),
    'logo_file' => env('images/logo.png'),
    'seller' => [
        'name' => env('Your company name'),
        'address' => env('Lagos Street, Lagos'),
        'email' => env('email@email.com'),
        'additional_info' => [
            'VAT Number' => env('XXXX XXXX XXXX')
        ]
    ],
    'currency' => env('CURRENCY', '&#8358;'),
];

?>
