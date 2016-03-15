<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="uk-slidenav-position" data-uk-slideshow>
	<ul class="uk-slideshow">
		<? foreach ($arResult['ITEMS'] as $arItem): ?>
		<li>
			<img src="<?= $arItem['PREVIEW_PICTURE_CACHE']['src'] ?>" alt="">
		</li>
		<? endforeach; ?>
	</ul>

	<a href="#"
	   class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous"
	   data-uk-slideshow-item="previous"
	   style="color: rgba(255,255,255,0.4)"></a>

	<a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next"
	   data-uk-slideshow-item="next"
	   style="color: rgba(255,255,255,0.4)"></a>

	<ul class="uk-dotnav uk-dotnav-contrast uk-position-bottom uk-flex-center">
		<? foreach ($arResult['ITEMS'] as $k => $arItem): ?>
		<li data-uk-slideshow-item="<?= $k ?>">
			<a href="#"><?= $k ?></a>
		</li>
		<? endforeach; ?>
	</ul>
</div>

