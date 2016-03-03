<?php

/**
 * Bitrix component iblock.content (webgsite.ru)
 * Компонент для битрикс, работа с инфоблоком одностраничный вывод
 *
 * @author    Falur <ienakaev@ya.ru>
 * @link      https://github.com/falur/bitrix.com.iblock.content
 * @copyright 2015 - 2016 webgsite.ru
 * @license   MIT
 */

use Bitrix\Main\Loader;
use CDBResult;
use CIBlockElement;
use CIBlock;

class IblockContentComponent extends CBitrixComponent
{
    protected $pagination;

    /**
     * Возвращает папрметры сортировки
     * 
     * @return array
     */
    protected function getSort()
    {
        $arSort = [
            $this->arParams['SORT_BY1'] => $this->arParams['SORT_ORDER1'],
            $this->arParams['SORT_BY2'] => $this->arParams['SORT_ORDER2'],
        ];

        if ($this->arParams['RAND_ELEMENTS'] == 'Y') {
            $arSort = [
                'RAND' => 'ASC'
            ];
        }

        return $arSort;
    }

    /**
     * Возвращает параметры фильтрации
     * 
     * @return array
     */
    protected function getFilter()
    {
        $arFilter = [
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'IBLOCK_LID' => SITE_ID,
            'IBLOCK_ACTIVE' => 'Y',
            'ACTIVE' => 'Y',
            'CHECK_PERMISSIONS' => 'Y',
            'MIN_PERMISSION' => 'R',
        ];

        if ($this->arParams['ACTIVE_DATE'] == 'Y') {
            $arFilter['ACTIVE_DATE'] = 'Y';
        }

        if (!empty($this->arParams['FILTER'])) {
            $arFilter = array_merge($this->arParams['FILTER'], $arFilter);
        }

        return $arFilter;
    }

    /**
     * Возвращает параметры количества выбранных записей
     * 
     * @return boolean|array
     */
    protected function getPaginationParams()
    {
        if ($this->arParams['PAGE_ELEMENT_COUNT'] == 0) {
            return false;
        }

        return [
            'nPageSize' => $this->arParams['PAGE_ELEMENT_COUNT'],
        ];
    }

    /**
     * Возвращает параметры выборки, т.е. какие поля выбирать
     * 
     * @return array
     */
    protected function getSelect()
    {
        return $arSelect = [
            'ID',
            'IBLOCK_ID',
            'CODE',
            'XML_ID',
            'NAME',
            'ACTIVE',
            'DATE_ACTIVE_FROM',
            'DATE_ACTIVE_TO',
            'SORT',
            'PREVIEW_TEXT',
            'PREVIEW_TEXT_TYPE',
            'DETAIL_TEXT',
            'DETAIL_TEXT_TYPE',
            'DATE_CREATE',
            'CREATED_BY',
            'TIMESTAMP_X',
            'MODIFIED_BY',
            'TAGS',
            'IBLOCK_SECTION_ID',
            'DETAIL_PAGE_URL',
            'DETAIL_PICTURE',
            'PREVIEW_PICTURE',
            'SHOW_COUNTER',
            'PROPERTY_*'
        ];
    }

    /**
     * Возвращает результат выборки
     *
     * @return array
     */
    protected function getData()
    {
        $arSort       = $this->getSort();
        $arSelect     = $this->getSelect();
        $arFilter     = $this->getFilter();
        $arPagination = $this->getPaginationParams();

        $arResult = [];
        $arItem   = [];

        $rsElements = CIBlockElement::GetList($arSort, $arFilter, false,
                $arPagination, $arSelect);

        while ($ob = $rsElements->GetNextElement()) {
            $arItem               = $ob->GetFields();
            $arItem['PROPERTIES'] = $ob->GetProperties();

            $arItem['PREVIEW_PICTURE'] = 0 < $arItem['PREVIEW_PICTURE']
                                         ? CFile::GetFileArray($arItem['PREVIEW_PICTURE'])
                                         : null;

            $arItem['DETAIL_PICTURE'] = 0 < $arItem['DETAIL_PICTURE']
                                        ? CFile::GetFileArray($arItem['DETAIL_PICTURE'])
                                        : null;

            $arItem['PREVIEW_PICTURE_CACHE'] = 0 < $arItem['PREVIEW_PICTURE']
                                               ? CFile::ResizeImageGet(
                                                  $arItem['PREVIEW_PICTURE'],
                                                  $this->arParams['IMG_CACHE']['PREVIEW_PICTURE']['SIZE'],
                                                  $this->arParams['IMG_CACHE']['PREVIEW_PICTURE']['TYPE']
                                                 )
                                               : null;

            $arItem['DETAIL_PICTURE_CACHE'] = 0 < $arItem['PREVIEW_PICTURE']
                                              ? CFile::ResizeImageGet(
                                                  $arItem['PREVIEW_PICTURE'],
                                                  $this->arParams['IMG_CACHE']['DETAIL_PICTURE']['SIZE'],
                                                  $this->arParams['IMG_CACHE']['DETAIL_PICTURE']['TYPE']
                                                )
                                              : null;

            $arButtons = CIBlock::GetPanelButtons(
                    $arItem['IBLOCK_ID'], $arItem['ID'], 0,
                    [
                    'SECTION_BUTTONS' => false,
                    'SESSID' => false
                    ]
            );

            $arItem['EDIT_LINK']   = $arButtons['edit']['edit_element']['ACTION_URL'];
            $arItem['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];

            $arResult[] = $arItem;
        }

        $this->arParams['PAGINATION']['NAME'] = 
            (isset($this->arParams['PAGINATION']['NAME']) && !empty($this->arParams['PAGINATION']['NAME']))
            ? $this->arParams['PAGINATION']['NAME']
            : 'Страницы';

        $this->arParams['PAGINATION']['TEMPLATE'] = 
            (isset($this->arParams['PAGINATION']['NAME']) && !empty($this->arParams['PAGINATION']['NAME']))
            ? $this->arParams['PAGINATION']['TEMPLATE']
            : '.default';

        $this->pagination = $rsElements->GetPageNavStringEx(
            $navComponentObject, $this->arParams['PAGINATION']['NAME'],
            $this->arParams['PAGINATION']['TEMPLATE']
        );

        return $arResult;
    }

    /**
     * Выполняет компонент
     *
     * @global CMain $APPLICATION
     */
    public function executeComponent()
    {
        Loader::includeModule('iblock');

        global $APPLICATION;

        $pages_count = $this->bitrix->arParams['PAGINATION']['COUNT'] ? : 10;
        $nav         = CDBResult::NavStringForCache($pages_count);
        $cache_id    = $APPLICATION->GetCurDir().$nav;

        if ($this->StartResultCache(false, $cache_id)) {
            $this->arResult['ITEMS']      = $this->getData();
            $this->arResult['PAGINATION'] = $this->pagination;
            $this->includeComponentTemplate();
        }
    }
}
