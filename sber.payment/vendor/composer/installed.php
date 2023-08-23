<?php return array(
    'root' => array(
        'name' => 'sber/payment',
        'pretty_version' => '0.1',
        'version' => '0.1.0.0',
        'reference' => NULL,
        'type' => 'bitrix-module',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '2a9170263fcd9cc4fd0b50917293c21d6c1a5bfe',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(
                0 => '2.x-dev',
            ),
            'dev_requirement' => false,
        ),
        'polus/module-settings' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => 'f9f9ab115d8c8335f8465c13469726ecd6e41792',
            'type' => 'library',
            'install_path' => __DIR__ . '/../polus/module-settings',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'sber/payment' => array(
            'pretty_version' => '0.1',
            'version' => '0.1.0.0',
            'reference' => NULL,
            'type' => 'bitrix-module',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
