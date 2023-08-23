<?php

use Bitrix\Main\Localization\Loc;

/** @global CMain $APPLICATION */
IncludeModuleLangFile(__FILE__);

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$moduleId = $request->get('id');

?><form action="<?= $APPLICATION->GetCurPage(); ?>" name="form1" class="c-deals">
    <?= bitrix_sessid_post(); ?>
    <input type="hidden" name="lang" value="<?= (LANGUAGE_ID) ?>">
	<input type="hidden" name="id" value="<?= ($moduleId) ?>">
	<input type="hidden" name="uninstall" value="Y">
	<input type="hidden" name="step" value="2">
	<div class="c-deals--params">
		<div class="ui-alert ui-alert-icon-warning ui-alert-warning">
			<span class="ui-alert-message"><?= (Loc::getMessage('SBER_PAYMENT_UNINSTALL_E_WARNING')) ?></span>
		</div>
		<br/>
		<label>
			<input type="checkbox" name="save_module_option" value="Y"/>
			<span><?= Loc::getMessage("SBER_PAYMENT_UNINSTALL_F_SAVE_OPTIONS") ?></span>
		</label>
		<label>
			<input type="checkbox" name="save_module_db" value="Y"/>
			<span><?= Loc::getMessage("SBER_PAYMENT_UNINSTALL_F_SAVE_DB") ?></span>
		</label>
	</div>
	<input type="submit" name="uninst" value="<?= Loc::getMessage("MOD_UNINST_DEL"); ?>">
</form>
<style type="text/css">
	.c-deals--params {
		display: flex;
		max-width: 850px;
		flex-direction: column;
		margin-bottom: 25px;
	}

	.c-deals--params label {
		margin-bottom: 10px;
		cursor: pointer;
	}
</style>