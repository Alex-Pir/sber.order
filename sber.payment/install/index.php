<?php

use Bitrix\Main;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Sber\Payment\Entity\TableManager;

Loc::loadMessages(__FILE__);

class SBER_PAYMENT extends CModule
{
	/**
	 * @var string код модуля
	 */
	public $MODULE_ID = 'sber.payment';
    
	/**
	 * @var string права модуля
	 */
	public $MODULE_GROUP_RIGHTS = 'N';
    
	/**
	 * @var string версия модуля
	 */
	public $MODULE_VERSION = '1.0.0';
    
	/**
	 * @var string дата создания или обновления модуля в формате Y-m-d
	 */
	public $MODULE_VERSION_DATE = '';
    
	/**
	 * @var string название модуля
	 */
	public $MODULE_NAME = '';
    
	/**
	 * @var string описание модуля
	 */
	public $MODULE_DESCRIPTION = '';
    
	/**
	 * @var string автор модуля
	 */
	public $PARTNER_NAME = '';
    
	/**
	 * @var string ссылка на сайт автора
	 */
	public $PARTNER_URI = '';
    
	/**
	 * @var string[] массив с моудлями, от которых звисит модуль
	 */
	protected array $SUB_MODULE = [];

	/**
	 * citrus_module_noname constructor.
	 */
	public function __construct()
	{
		$this->MODULE_NAME = Loc::getMessage('SBER_PAYMENT_F_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('SBER_PAYMENT_F_DESCRIPTION');

		$this->PARTNER_NAME = Loc::getMessage('SBER_PAYMENT_F_COMPANY_NAME');
		$this->PARTNER_URI = Loc::getMessage('SBER_PAYMENT_F_COMPANY_URI');

		$this->loadVersion();
	}

	public function doInstall(): void
	{
		global $APPLICATION;

		try {
			$this->loadSubModules();

			Main\ModuleManager::registerModule($this->MODULE_ID);
			Loader::includeModule($this->MODULE_ID);

			$this->installDb();
            $this->installFiles();
		} catch (Exception $ex) {
			Main\ModuleManager::unRegisterModule($this->MODULE_ID);
			$APPLICATION->ThrowException($ex->getMessage());
		}

		$APPLICATION->IncludeAdminFile(
			Loc::getMessage('SBER_PAYMENT_F_INSTALL_TITLE',
				array('#MODULE#' => $this->MODULE_NAME, '#MODULE_ID#' => $this->MODULE_ID)), __DIR__ . '/step1.php'
		);
	}

	public function doUninstall(): void
	{
		global $APPLICATION, $step;

		$step = (int)$step;

		try {
			if ($step <= 1) {
				$APPLICATION->IncludeAdminFile(
					Loc::getMessage('SBER_PAYMENT_F_INSTALL_TITLE',
						array('#MODULE#' => $this->MODULE_NAME)), __DIR__ . '/uninstall/step1.php'
				);
			} else {
				Loader::includeModule($this->MODULE_ID);

				$request = Application::getInstance()->getContext()->getRequest();
				$saveData = ('Y' == $request->get('save_module_db'));
				$saveOptions = ('Y' == $request->get('save_module_option'));

				if (!$saveData) {
					$this->unInstallDB();
				}

				if (!$saveOptions) {
					Main\Config\Option::delete($this->MODULE_ID);
				}

				$this->uninstallFiles();

				Main\ModuleManager::unRegisterModule($this->MODULE_ID);

				$APPLICATION->IncludeAdminFile(
					Loc::getMessage('SBER_PAYMENT_F_INSTALL_TITLE',
						array('#MODULE#' => $this->MODULE_NAME)), __DIR__ . '/uninstall/step2.php'
				);
			}
		} catch (Exception $ex) {
			$APPLICATION->ThrowException($ex->getMessage());
			$APPLICATION->IncludeAdminFile(
				Loc::getMessage('SBER_PAYMENT_F_INSTALL_TITLE',
					array('#MODULE#' => $this->MODULE_NAME)), __DIR__ . '/uninstall/step1.php'
			);
		}
	}

	function installDB(): void
    {
        TableManager::install();
	}

	function unInstallDB(): void
    {
        TableManager::uninstall();
	}

	/**
	 * Копирование файлов модуля
	 */
	public function installFiles(): void
	{
        CopyDirFiles(__DIR__ . '/components', Main\Application::getDocumentRoot() . SBER_PAYMENT_BX_ROOT . '/components/' . SBER_PAYMENT_MODULE, true, true);
	}

	/**
	 * Удаление файлов модуля
	 */
	public function uninstallFiles(): void
	{
		DeleteDirFilesEx(SBER_PAYMENT_BX_ROOT . '/components/' . SBER_PAYMENT_MODULE);
	}


	/**
	 * Установить данные по версии модуля
	 */
	protected function loadVersion(): void
	{
		$arModuleVersion = array(
			'VERSION' => '1.0.0',
			'VERSION_DATE' => DateTime::createFromFormat('Y-m-d', time()),
		);

		@include __DIR__ . '/version.php';

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}
	}

	/**
	 * Подключение к БД
	 *
	 * @return Main\DB\Connection
	 */
	protected function getConnection(): Main\DB\Connection
    {
		return Main\Application::getInstance()->getConnection();
	}

	/**
	 * Подключение дополнительных модулей
	 * @throws Exception
	 */
	protected function loadSubModules(): void
	{
		try {
			foreach ($this->SUB_MODULE as $module) {
				if (true === Loader::includeModule($module)) {
                    continue;
                }

				throw new Exception(Loc::getMessage('SBER_PAYMENT_ERROR_SUBMODULE', [
					'#MODULE_NAME#' => $this->MODULE_ID,
					'#SUB_MODULE_NAME#' => $module
				]));
			}
		} catch (Exception $ex) {
			throw new Exception($ex->getMessage());
		}
	}
}
