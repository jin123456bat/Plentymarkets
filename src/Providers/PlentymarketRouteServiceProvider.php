<?php
namespace Plentymarket\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;
use Plenty\Plugin\Routing\Router;

/**
 * Class HelloWorldRouteServiceProvider
 * @package HelloWorld\Providers
 */
class PlentymarketRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param Router $router
	 */
	public function map (Router $router, ApiRouter $api)
	{
		//接口声明
		$api->version(['v1'], ['namespace' => 'Plentymarket\Controllers\Api', 'middleware' => []], function (ApiRouter $apiRouter) {
			$apiRouter->post('/api/index/login', 'IndexController@login');
			$apiRouter->post('/api/index/register', 'IndexController@register');
		});

		$router->get('/', 'Plentymarket\Controllers\Web\IndexController@index');
		$router->get('/index/about', 'Plentymarket\Controllers\Web\IndexController@about');
		$router->get('/index/contact', 'Plentymarket\Controllers\Web\IndexController@contact');
		$router->get('/index/faq', 'Plentymarket\Controllers\Web\IndexController@faq');
		$router->get('/index/login_register', 'Plentymarket\Controllers\Web\IndexController@login_register');

		$router->get('/account/index', 'Plentymarket\Controllers\Web\AccountController@index');
		$router->get('/account/cart', 'Plentymarket\Controllers\Web\AccountController@cart');
		$router->get('/account/checkout', 'Plentymarket\Controllers\Web\AccountController@checkout');
		$router->get('/account/wishlist', 'Plentymarket\Controllers\Web\AccountController@wishlist');
	}

}
