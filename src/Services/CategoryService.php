<?php

namespace Plentymarket\Services;

use Plenty\Modules\Category\Contracts\CategoryRepositoryContract;
use Plenty\Repositories\Models\PaginatedResult;

/**
 * Class CategoryService
 * @package Plentymarket\Services
 */
class CategoryService
{
	/**
	 * @var CategoryRepositoryContract
	 */
	private $categoryRepositoryContract;

	/**
	 * CategoryService constructor.
	 * @param CategoryRepositoryContract $categoryRepositoryContract
	 */
	function __construct (CategoryRepositoryContract $categoryRepositoryContract)
	{
		$this->categoryRepositoryContract = $categoryRepositoryContract;
	}

	/**
	 * 获取所有分类
	 * @return PaginatedResult
	 */
	function getAll ()
	{
		return $this->categoryRepositoryContract->search(null, 0, 99999, [], []);
	}

	/**
	 * 获取树状分类图
	 * @param string $type
	 * @return array
	 */
	function getTree (string $type = 'item')
	{
		$categoryTree = [];
		$category_list = $this->getAll()->getResult();
		foreach ($category_list as $value) {
			if (empty($value['parentCategoryId']) && $value['type'] == $type) {
				$value['children'] = $this->getSubCategory($category_list, $value['id'], $type);
				$categoryTree[] = $value;
			}
		}
		return $categoryTree;
	}

	/**
	 * 获取分类的子分类
	 * @param $category_list
	 * @param int|null $category_id
	 * @param string $type
	 * @return array
	 */
	function getSubCategory ($category_list, int $category_id = null, $type = 'item')
	{
		$temp_category_list = [];
		foreach ($category_list as $value) {
			if ($value['parentCategoryId'] == $category_id && $value['type'] == $type) {
				$value['children'] = $this->getSubCategory($category_list, $value['id']);
				$temp_category_list[] = $value;
			}
		}
		return $temp_category_list;
	}

}