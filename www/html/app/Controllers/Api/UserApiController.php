<?php

declare(strict_types=1);

namespace WJCrypto\Controllers\Api;

use Couchbase\User;
use WJCrypto\Controllers\AccountController;
use WJCrypto\Models\UserModel;
use WJCrypto\Helpers;

class UserApiController extends UserModel
{
    /**
     * @var AccountController
     */
    private $account;

    public function __construct()
    {
        parent::__construct();
        $this->account = Helpers::getContainer('AccountController');
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'));

        $data->cpf_cnpj = Helpers::encryptData($data->cpf_cnpj);

        try {
            if (!parent::userExists($data->cpf_cnpj)) {
                throw new \Exception(parent::USER_NOT_FOUND);
            }

            $user = parent::getUserData($data->cpf_cnpj);

            if (!password_verify($data->senha, $user->senha)) {
                throw new \Exception(parent::USER_WRONG_PASSWORD);
            }

            $user->account = $this->account->getAccountData($user->id);

            $token = parent::setAuthenticationToken($user->id);

            $message = parent::USER_AUTHENTICATED;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if ($message == parent::USER_AUTHENTICATED) {
            Helpers::apiResponse($message, [
                'user_id' => $user->id,
                'username' => $user->nome_razao,
                'account' => $user->account->account,
                'token' => $token
            ]);
        }

        Helpers::apiResponse($message);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'));

        try {
            parent::createUser($data);

            $user_id = parent::lastCreatedUser();

            $this->account->create($user_id);

            $message = parent::USER_CREATION_SUCCESFUL;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        Helpers::apiResponse($message);
    }
}
