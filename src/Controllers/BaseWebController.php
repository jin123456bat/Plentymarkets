<?php

namespace Plentymarket\Controllers;

use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Templates\Twig;
use Plentymarket\Services\AccountService;
use Plentymarket\Services\CategoryService;

/**
 * Class BaseWebController
 * @package Plentymarket\Controllers
 */
class BaseWebController extends BaseController
{
	/**
	 * @var Twig
	 */
	protected $twig;

	/**
	 * BaseWebController constructor.
	 * @param Request $request
	 * @param Response $response
	 */
	function __construct (Request $request, Response $response)
	{
		$this->twig = pluginApp(Twig::class);
		parent::__construct($request, $response);
	}

	/**
	 * @param string $template
	 * @param array $breadcrumb
	 * @param array $context
	 * @return string
	 */
	function render (string $template, array $breadcrumb = [], array $context = []): string
	{
		//面包屑
		$context['breadcrumb'] = array_merge([
			$this->trans('Common.home') => '/',
		], $breadcrumb);

		//用户信息
		$context['contact'] = pluginApp(AccountService::class)->getContact();

		//分类
		$context['category'] = pluginApp(CategoryService::class)->getTree();

		//footer中的文章信息
//		$footer_article_1 = pluginApp(ConfigService::class)->getTemplateConfig('basic.footer_article_1');
//		$context['footer_article_1'] = $footer_article_1;
//		$footer_article_2 = pluginApp(ConfigService::class)->getTemplateConfig('basic.footer_article_1');
//		$context['footer_article_2'] = $footer_article_2;
//		$context['footer_article_1_list'] = pluginApp(BlogService::class)->category_id($footer_article_1 . id);
//		$context['footer_article_2_list'] = pluginApp(BlogService::class)->category_id($footer_article_2 . id);

		return $this->twig->render('Plentymarket::' . $template, $context);
	}

	/**
	 * 输出异常信息
	 * @param \Throwable $e
	 * @return string
	 */
	protected function exception (\Throwable $e): string
	{
		return json_encode([
			'code' => 0,
			'message' => $e->getMessage(),
			'data' => [
				'code' => $e->getCode(),
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'trace' => $e->getTrace(),
			]
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	}
}
