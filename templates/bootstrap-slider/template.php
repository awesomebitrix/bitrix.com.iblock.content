<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div id="slider" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<? foreach ($arResult['ITEMS'] as $k => $arItem): ?>
		<li data-target="#slider" data-slide-to="<?= $k ?>" class="<?= $k == 0 ? 'active' : '' ?>"></li>
		<? endforeach; ?>
	</ol>

	<div class="carousel-inner" role="listbox">
		<? foreach ($arResult['ITEMS'] as $k => $arItem): ?>
		<div class="item <?= $k == 0 ? 'active' : '' ?>">
			<img src="<?= $arItem['PREVIEW_PICTURE_CACHE']['src'] ?>" alt="">
			<div class="carousel-caption">
				<?= $arItem['PREVIEW_TEXT'] ?>
			</div>
		</div>
		<? endforeach; ?>
	</div>

	<a class="left carousel-control" href="#slider" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Назад</span>
	</a>
	
	<a class="right carousel-control" href="#slider" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Далее</span>
	</a>
</div>
