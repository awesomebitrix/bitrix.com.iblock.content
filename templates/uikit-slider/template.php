<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="uk-slidenav-position" data-uk-slider>
	<div class="uk-slider-container">
		<ul class="uk-slider uk-grid-width-medium-1-4">
			<? foreach ($arResult['ITEMS'] as $arItem): ?>
			<li>
				<img src="<?= $arItem['PREVIEW_PICTURE_CACHE']['src'] ?>" alt="">
			</li>
			<? endforeach; ?>
		</ul>
	</div>

	<a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
	<a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
</div>