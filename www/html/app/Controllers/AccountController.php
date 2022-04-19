<?php

namespace WJCrypto\Controllers;

use WJCrypto\Helpers;
use WJCrypto\Models\AccountModel;

class AccountController extends AccountModel
{
    /**
     * @var FrontendController
     */
    private $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = Helpers::getContainer('FrontendController');
    }

    public function create($user_id)
    {
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

    public function getAccountData($user_id)
    {
        return parent::getAccount($user_id);
    }

    public function transactionHistory($account)
    {
        return parent::getTransactionHistory($account);
    }

    public function depositController()
    {
        $qty = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        parent::deposit($_SESSION['account'], $qty);

        Helpers::response()->redirect('/dashboard');
    }

    public function withdrawController()
    {
        $qty = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        parent::withdraw($_SESSION['account'], $qty);

        Helpers::response()->redirect('/dashboard');
    }

    public function transferController()
    {
        $targetAccount = filter_input(INPUT_POST, 'conta', FILTER_SANITIZE_STRING);
        $qty = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        parent::transfer($targetAccount, $qty);
        Helpers::response()->redirect('/dashboard');
    }
}
