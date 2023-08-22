<?php
return [
    'controllers' => [
        'value' => [
            'defaultNamespace' => "\\Sber\\Payment\\Controllers",
            'restIntegration' => [
                'enabled' => true,
            ],
        ],
        'readonly' => true,
    ],
    'services' => [
        'value' => [
            \Sber\Payment\Contracts\PaymentGatewayContract::class => [
                'className' => \Sber\Payment\Payment\Gateway\SberGateway::class
            ]
        ]
    ]
];
