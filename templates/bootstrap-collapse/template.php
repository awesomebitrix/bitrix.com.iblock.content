<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<? foreach ($arResult['ITEMS'] as $id => $arItem): ?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="h<?= $id ?>">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $id ?>" aria-expanded="true" aria-controls="collapse<?= $id ?>">
					<?= $arItem['NAME'] ?>
				</a>
			</h4>
		</div>
		
		<div id="collapse<?= $id ?>" class="panel-collapse collapse <?= $id == 0 ? 'in' : 0 ?>" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
				<?= $arItem['PREVIEW_TEXT'] ?>
			</div>
		</div>
	</div>
	<? endforeach; ?>
</div>