<?php

namespace WJCrypto\Controllers;

use WJCrypto\Helpers;
use WJCrypto\Models\AccountModel;

class AccountController extends AccountModel
{
    /**
     * @var UserController
     */
    private $user;

    /**
     * @var FrontendController
     */
    private $view;

    public function __construct()
    {
        parent::__construct();
        $this->user = Helpers::getContainer('UserController');
        $this->view = Helpers::getContainer('FrontendController');
    }

    public function create()
    {
        $param = [];

        if (!$this->user->create()) {
            echo $this->view->showNewAccPage(['message' => 'Erro ao criar o usuário']);
        }

        $user_id = $this->user->getLastUserCreated();

        $data = [
            'user_id' => $user_id,
            'account' => sprintf('%05d', $user_id).'-1',
            'saldo' => 0
        ];

        if (!parent::createAccount($data)) {
            echo $this->view->showNewAccPage(['message' => 'Erro ao criar sua conta']);
        }

        echo $this->view->showNewAccPage(
            ['message' => 'Conta Criada com sucesso']
        );
    }
}
