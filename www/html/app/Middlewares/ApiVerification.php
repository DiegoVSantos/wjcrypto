<?php

declare(strict_types=1);

namespace WJCrypto\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use WJCrypto\Helpers;
use WJCrypto\Models\UserModel;

class ApiVerification implements IMiddleware
{
    /**
     * @var UserModel
     */
    private $user;

    public function __construct()
    {
        $this->user = Helpers::getContainer('UserModel');
    }

    public function handle(Request $request) : void
	{
        try {
            $authentication_header = $request->getHeader('Authorization');
            if ($authentication_header == null) {
                throw new \Exception('Needs authentication header');
            }

            $authentication_token = substr($authentication_header, 7);
            if (!$this->user->getAuthenticationToken($authentication_token)) {
                throw new \Exception('Invalid authentication token');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();

            Helpers::apiResponse($message);
        }
	}

}