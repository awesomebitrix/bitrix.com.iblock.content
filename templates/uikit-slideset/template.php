<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="uk-margin" data-uk-slideset="{default: 4}">
	<div class="uk-slidenav-position uk-margin">
		<ul class="uk-slideset uk-grid uk-flex-center">
			<? foreach ($arResult['ITEMS'] as $arItem): ?>
			<li>
				<div class="uk-panel uk-panel-box">
					<div class="uk-panel-teaser">
						<img src="<?= $arItem['PREVIEW_PICTURE_CACHE']['src'] ?>" alt="">
					</div>
					<div class="uk-h3"><?= $arItem['NAME'] ?></div>
					<p><?= $arItem['PREVIEW_TEXT'] ?></p>
				</div>
			</li>
			<? endforeach; ?>
		</ul>

		<a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
		<a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
	</div>

	<ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
</div>