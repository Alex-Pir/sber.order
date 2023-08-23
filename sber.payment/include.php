<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

define('SBER_PAYMENT_MODULE', basename(__DIR__)); //sber.payment
define('SBER_PAYMENT_BX_ROOT', strpos(getLocalPath('modules/' . SBER_PAYMENT_MODULE), '/local') === 0 ? '/local' : BX_ROOT);
define('SBER_PAYMENT_MODULE_DIR', SBER_PAYMENT_BX_ROOT . '/modules/' . SBER_PAYMENT_MODULE);

if (file_exists( __DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
