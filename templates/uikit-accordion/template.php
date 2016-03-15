<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="uk-accordion" data-uk-accordion>
	<? foreach ($arResult['ITEMS'] as $arItem): ?>
	<div class="uk-h3 uk-accordion-title"><?= $arItem['NAME'] ?></div>
	<div class="uk-accordion-content">
		<p><?= strip_tags($arItem['PREVIEW_TEXT']) ?></p>
	</div>
	<? endforeach; ?>
</div>


