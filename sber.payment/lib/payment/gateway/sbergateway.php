<?php

namespace Sber\Payment\Payment\Gateway;

use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use Sber\Payment\Constants;
use Sber\Payment\Contracts\PaymentGatewayContract;
use Sber\Payment\Exceptions\PaymentException;
use Sber\Payment\Payment\PaymentData;
use Sber\Payment\Support\Traits\HasModuleOptions;

class SberGateway implements PaymentGatewayContract
{
    use HasModuleOptions;

    protected array $errorMessages = [
        1 => 'Неверный номер заказа',
        3 => 'Неизвестная валюта',
        4 => 'Проверьте правильность заполнения параметров заказа',
        5 => 'Доступ запрещён',
        7 => 'Системная ошибка',
    ];

    protected const PAY_STATUS_SUCCESS = 2;

    protected array $parameters = [];

    protected PaymentData $paymentData;

    protected bool $isPaid = false;

    public function configure(): array
    {
        return [
            'SBERBANK_PROD_URL' => 'https://securepayments.sberbank.ru/payment/rest/',
            'SBERBANK_TEST_URL' => 'https://3dsec.sberbank.ru/payment/rest/',
            'ISO' => [
                'USD' => 840,
                'EUR' => 978,
                'RUB' => 643,
                'RUR' => 643,
                'BYN' => 933
            ]
        ];
    }

    public function data(PaymentData $data): PaymentGatewayContract
    {
        $this->paymentData = $data;

        return $this;
    }

    /**
     * @throws PaymentException
     */
    public function register(): string
    {
        $config = $this->configure();

        $parameters = [
            'userName' => static::getModuleOption(Constants::LOGIN_SETTINGS),
            'password' => static::getModuleOption(Constants::PASSWORD_SETTINGS),
            'orderNumber' => $this->paymentData->id,
            'returnUrl' => static::getModuleOption(Constants::URL_RETURN_SETTINGS),
            'amount' => $this->paymentData->price->current(),
            'currency' => $config['ISO'][$this->paymentData->price->currency()],
            'params' => json_encode(array('formUrl' => ''))
        ];

        $response = $this->sendRequest('register.do', $parameters);

        if (isset($response['errorCode'])) {
            PaymentException::throw($this->errorMessage((int)$response['errorCode']));
        }

        return $response['formUrl'];
    }

    /**
     * @throws PaymentException
     */
    public function state(): array
    {
        $parameters = [
            'userName' => static::getModuleOption(Constants::LOGIN_SETTINGS),
            'password' => static::getModuleOption(Constants::PASSWORD_SETTINGS),
            'orderId' => $this->paymentData->id,
        ];

        $response = $this->sendRequest('getOrderStatusExtended.do', $parameters);

        if (isset($response['errorCode'])) {
            PaymentException::throw($this->errorMessage((int)$response['errorCode']));
        }

        $this->isPaid = $response['orderStatus'] == static::PAY_STATUS_SUCCESS;

        return $response;
    }

    public function url(): string
    {
        $config = $this->configure();

        return static::getModuleOption(Constants::IS_TEST_SETTINGS)
            ? $config['SBERBANK_TEST_URL']
            : $config['SBERBANK_PROD_URL'];
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function errorMessage(int $code): string
    {
        if (!isset($this->errorMessages[$code])) {
            return 'Неизвестная ошибка';
        }

        return $this->errorMessages[$code];
    }

    protected function sendRequest(string $method, array $parameters): array
    {
        $http = new HttpClient();

        $http->setCharset('utf-8');
        $http->disableSslVerification();
        $http->post($this->url() . $method, $parameters);

        return Json::decode($http->getResult());
    }
}
