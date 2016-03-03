# iblock.content

Универсальный компонент инфоблоков для CMS Bitrix (замена news.list). 
Вывод одностраничниго контента

```php
$APPLICATION->IncludeComponent(
	"falur:iblock.content",
	"",
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"SORT_BY1" => "DATE_ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "DESC",
		"FILTER" => [],
		"PAGE_ELEMENT_COUNT" => "4",
		"RAND_ELEMENTS" => "N",
        // Не обязательный параметр
        "PAGINATION" => [
            "NAME" => "Страницы",
            "TEMPLATE" => ".default"
        ],
        // Не обязательный параметр
        "IMG_CACHE" => [
            // Не обязательный параметр
            "PREVIEW_PICTURE" => [
                "SIZE" => ["width" => 200, "height" => 200],
                "TYPE" => BX_RESIZE_IMAGE_EXACT
            ],
            // Не обязательный параметр
            "DETAIL_PICTURE" => [
                "SIZE" => ["width" => 200, "height" => 200],
                "TYPE" => BX_RESIZE_IMAGE_EXACT
            ]
        ],
        "CACHE_TYPE" => "A", 
        "CACHE_TIME" => 3600 
	)
);
```