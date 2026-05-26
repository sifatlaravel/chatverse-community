<?php

return [
    'billing' => [
        'bank' => [
            'enabled' => filter_var(env('BILLING_BANK_ENABLED', true), FILTER_VALIDATE_BOOL),
            'name' => env('BILLING_BANK_NAME', ''),
            'account_name' => env('BILLING_BANK_ACCOUNT_NAME', ''),
            'account_number' => env('BILLING_BANK_ACCOUNT_NUMBER', ''),
            'routing' => env('BILLING_BANK_ROUTING', ''),
            'swift' => env('BILLING_BANK_SWIFT', ''),
            'branch' => env('BILLING_BANK_BRANCH', ''),
            'note' => env('BILLING_BANK_NOTE', ''),
        ],
        'bkash' => [
            'enabled' => filter_var(env('BILLING_BKASH_ENABLED', true), FILTER_VALIDATE_BOOL),
            'number' => env('BILLING_BKASH_NUMBER', ''),
            'type' => env('BILLING_BKASH_TYPE', 'Personal'),
            'note' => env('BILLING_BKASH_NOTE', ''),
        ],
    ],
];
