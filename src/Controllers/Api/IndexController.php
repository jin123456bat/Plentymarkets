<?php

namespace Plentymarket\Controllers\Api;

use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plentymarket\Controllers\BaseApiController;
use Plentymarket\Services\AccountService;

/**
 * Class IndexController
 * @package Plentymarket\Controllers\Api
 */
class IndexController extends BaseApiController
{
	/**
	 * @var AccountService
	 */
	private $accountService;

	/**
	 * IndexController constructor.
	 * @param Request $request
	 * @param Response $response
	 * @param AccountService $accountService
	 */
	function __construct (Request $request, Response $response, AccountService $accountService)
	{
		parent::__construct($request, $response);
		$this->accountService = $accountService;
	}

	/**
	 * @return Response
	 */
	public function login (): Response
	{
		try {
			$email = $this->request->get('email');
			$password = $this->request->get('password');

			if (empty($email) || empty($password)) {
				return $this->error($this->trans("ApiIndex.loginEmailOrPasswordError"));
			}

			if ($this->accountService->login($email, $password)) {
				return $this->success($this->trans('ApiIndex.loginSuccess'));
			} else {
				return $this->error($this->trans('ApiIndex.loginEmailOrPasswordError'));
			}
		} catch (\Exception $e) {
			return $this->response->make('Exception!!!!', 200);
		}
	}

	/**
	 * @return Response
	 */
	public function register (): Response
	{
		$email = $this->request->get('email');
		$password = $this->request->get('password');

		if (empty($email) || empty($password)) {
			return $this->error($this->trans("ApiIndex.registerEmailOrPasswordError"));
		}

		if ($this->accountService->register($email, $password)) {
			return $this->success($this->trans("ApiIndex.registerSuccess"));
		} else {
			return $this->error($this->trans("ApiIndex.registerEmailExist"));
		}
	}
}
