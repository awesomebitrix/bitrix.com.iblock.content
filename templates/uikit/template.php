<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * Bitrix component iblock.content (webgsite.ru)
 * Компонент для битрикс, работа с инфоблоком одностраничный вывод
 *
 * @author    Falur <ienakaev@ya.ru>
 * @link      https://github.com/falur/bitrix.com.iblock.content
 * @copyright 2015 - 2016 webgsite.ru
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl-2.0.html
 */
?>

<? foreach($arResult['ITEMS'] as $arItem): ?>
<?php
$ee = CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT');
$ed = CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE');
$msg = ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')];
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $ee);
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $ed, $msg);
?>
<div class="uk-article" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
    <div class="uk-article-title"><?= $arItem['NAME'] ?></div>

	<? if ($arItem['DATE_ACTIVE_FROM']): ?>
	<p class="uk-article-meta"><?= $arItem['DATE_ACTIVE_FROM'] ?></p>
	<? endif; ?>	

    <div class="uk-clearfix">
         <? if ($arItem['PREVIEW_PICTURE_CACHE'] || $arItem['DETAIL_PICTURE_CACHE']): ?>
            <img class="uk-align-medium-right"
                 src="<?= $arItem['PREVIEW_PICTURE_CACHE']
                          ? $arItem['PREVIEW_PICTURE_CACHE']['src']
                          : $arItem['DETAIL_PICTURE_CACHE']['src'] ?>"
                 alt="">
         <? endif ?>
            
        <?= $arItem['PREVIEW_TEXT'] ?>
    </div>
   
    <hr class="uk-article-divider">
    
    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">Подробнее</a>
</div>
<? endforeach; ?>

<?= $arResult['PAGINATION'] ?>
