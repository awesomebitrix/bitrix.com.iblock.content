bitrix_iblock
=============

Универсальный компонент инфоблоков для CMS Bitrix (замена news.list)

```php
$APPLICATION->IncludeComponent(
	"main:iblock.content",
	"",
	Array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"SORT_BY1" => "DATE_ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "DESC",
		"FILTER" => [],
		"PAGE_ELEMENT_COUNT" => "4",
		"RAND_ELEMENTS" => "N"
	)
);
```