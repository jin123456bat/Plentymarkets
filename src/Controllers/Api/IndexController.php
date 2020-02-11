<?php

namespace Plentymarket\Controllers\Api;

use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plentymarket\Controllers\BaseApiController;
use Plentymarket\Services\AccountService;

/**
 * Class ContentController
 * @package HelloWorld\Controllers
 */
class IndexController extends BaseApiController
{
	private $accountService;

	function __construct (Request $request, Response $response, AccountService $accountService)
	{
		parent::__construct($request, $response);
		$this->accountService = $accountService;
	}

	/**
	 *
	 */
	public function login ()
	{
		return $this->success('登录成功');
	}

	public function register ()
	{
		$email = $this->request->get('email');
		$password = $this->request->get('password');

		if (empty($email) || empty($password))
		{
			return $this->error(trans("Plentymarket::Register.emailOrPasswordError"));
		}

		if ($this->accountService->register($email, $password)) {
			return $this->success(trans("Plentymarket::Register.success"));
		} else {
			return $this->error(trans("Plentymarket::Register.emailExist"));
		}
	}
}
