<?php

/**
 * @var $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;
?>
<div id="order-form">
    <div class="error" v-for="(error, index) in errors" v-html="error"></div>
    <div class="form-field">
        <span>Фамилия</span>
        <input type="text" v-model="lastName" required>
    </div>
    <div class="form-field">
        <span>Имя</span>
        <input type="text" v-model="name" required>
    </div>
    <div class="form-field">
        <span>Отчество</span>
        <input type="text" v-model="secondName">
    </div>
    <div class="form-field">
        <span>Товар</span>
        <select @change="preparePrice" v-model="productId">
            <option v-for="product in PRODUCTS" :key=product.ID :value="product.ID" v-html="product.NAME"></option>
        </select>
    </div>
    <div class="form-field">
        <span>Количество</span>
        <input type="number" step="1" min="1" name="amount" v-model="amount" @change="preparePrice">
    </div>
    <div class="form-field">
        <span>Цена</span>
        <span v-html="price"></span>
    </div>
    <input type="submit" @click.prevent="createOrder">
</div>

<script>
    (new BX.Polus.Init.VueInit(
        BX.Polus.Components.OrderPaymentForm,
        '#order-form',
        <?= Json::encode($arResult) ?>
    )).init();
</script>
