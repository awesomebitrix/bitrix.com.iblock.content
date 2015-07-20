<?php

use \Bitrix\Main\Loader;

class IblockContent extends CBitrixComponent
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
		
		if ($this->arParams['RAND_ELEMENTS'] == 'Y')
			$arSort = [
				'RAND' => 'ASC'
			];
		
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
		
		if ($this->arParams['ACTIVE_DATE'] == 'Y') $arFilter['ACTIVE_DATE'] = 'Y';
		
		if (!empty($this->arParams['FILTER']))
			$arFilter = array_merge($this->arParams['FILTER'], $arFilter);
			
		return $arFilter;
	}
	
	/**
	 * Возвращает параметры количества выбранных записей
	 * 
	 * @return boolean|array
	 */
	protected function getPaginationParams()
	{
		if ($this->arParams['PAGE_ELEMENT_COUNT'] == 0)
			return false;
		
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
		$arSort		  = $this->getSort();
		$arSelect	  = $this->getSelect();
		$arFilter	  = $this->getFilter();
		$arPagination = $this->getPaginationParams();
		
		$arResult = [];
		$arItem   = [];
		
		$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, $arPagination, $arSelect);
		while ($ob = $rsElements->GetNextElement())
		{
			$arItem = $ob->GetFields();
			$arItem['PROPERTIES'] = $ob->GetProperties();

			$arItem['PREVIEW_PICTURE'] = (0 < $arItem['PREVIEW_PICTURE'] ? CFile::GetFileArray($arItem['PREVIEW_PICTURE']) : false);
			$arItem['DETAIL_PICTURE']  = (0 < $arItem['DETAIL_PICTURE']  ? CFile::GetFileArray($arItem['DETAIL_PICTURE'])  : false);

			$arButtons = CIBlock::GetPanelButtons(
					$arItem['IBLOCK_ID'], 
					$arItem['ID'], 
					0, 
					[
						'SECTION_BUTTONS' => false, 
						'SESSID' => false
					]
			);
			$arItem['EDIT_LINK']   = $arButtons['edit']['edit_element']['ACTION_URL'];
			$arItem['DELETE_LINK'] = $arButtons['edit']['delete_element']['ACTION_URL'];

			$arResult[] = $arItem;
		}
		
		$this->arParams['PAGINATION']['NAME'] = (isset($this->arParams['PAGINATION']['NAME']) && !empty($this->arParams['PAGINATION']['NAME'])) ? $this->arParams['PAGINATION']['NAME'] : 'Страницы';
		
		$this->arParams['PAGINATION']['TEMPLATE'] = (isset($this->arParams['PAGINATION']['NAME']) && !empty($this->arParams['PAGINATION']['NAME'])) ? $this->arParams['PAGINATION']['TEMPLATE'] : '.default';
		
		$this->pagination =  $rsElements->GetPageNavStringEx(
			$navComponentObject, 
			$this->arParams['PAGINATION']['NAME'], 
			$this->arParams['PAGINATION']['TEMPLATE']
		);
		
		return $arResult;
	}
	
	/**
	 * Выполняет компонент
	 */
	public function executeComponent()
	{
		Loader::includeModule('iblock');
		
		global $APPLICATION;
		
		$arNavParams = [
			"nPageSize" => $this->bitrix->arParams['PAGINATION']['COUNT'] ?: 10,
			"bDescPageNumbering" => false,
			"bShowAll" => false,
		];
		$arNavigation = \CDBResult::GetNavParams($arNavParams);
		
		$get_params = $_GET['PAGEN_1'] ?: $_GET['PAGEN_2'] ?: $_GET['PAGEN_3'] ?: $_GET['PAGEN_4'] ?: $_GET['PAGEN_5'] ?: '';
		$cache_id = $APPLICATION->GetCurDir() . $arNavigation['SESS_PAGEN'] . $get_params;
		
		if ($this->StartResultCache(false, $cache_id, $arNavigation))
		{
			$this->arResult['ITEMS'] = $this->getData();
			$this->arResult['PAGINATION'] = $this->pagination;
			$this->includeComponentTemplate();
		}
	}
}
