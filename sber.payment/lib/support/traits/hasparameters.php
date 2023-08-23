<?php

namespace Sber\Payment\Support\Traits;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Json;
use Exception;

trait HasParameters
{

    protected array $parameters = [];

    public function getParameter(string $code, $defaultValue = null)
    {
        $this->initParameters();

        if (isset($this->parameters[$code])) {
            return $this->parameters[$code];
        }

        return $defaultValue;
    }

    public function getAllParameters(): array
    {
        $this->initParameters();
        return $this->parameters;
    }

    protected function initParameters(): void
    {
        $input = $this->request->getInput();

        try {
            if ($input) {
                $input = urldecode($input);
                $input = preg_replace('/,\s*([\]}])/m', '$1', $input);
                $this->parameters = Json::decode($input);
            }
        } catch (Exception $ex) {
            AddMessage2Log($ex->getMessage());
        }

        if (!$this->parameters) {
            $this->parameters = $_REQUEST;
        }
    }

    public function transformParameterKeysToUpper(array &$parameters, int $deep = 0, int $maxDeep = 3): void
    {
        $parameters = array_change_key_case($parameters, CASE_UPPER);

        foreach ($parameters as &$parameter) {
            if (is_array($parameter) && $deep <= $maxDeep) {
                $this->transformParameterKeysToUpper($parameter, $deep + 1);
            }
        }
    }
}