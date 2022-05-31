<?php

declare(strict_types=1);

namespace WJCrypto\Controllers;

use WJCrypto\Helpers;
use WJCrypto\Models\UserModel;

class UserController
{
    /**
     * @var FrontendController $view
     */
    private $view;

    /**
     * @var AccountController
     */
    private $account;

    /**
     * @var UserModel
     */
    private $user;

    public function __construct()
    {
        $this->view = Helpers::getContainer('FrontendController');
        $this->account = Helpers::getContainer('AccountController');
        $this->user = Helpers::getContainer('UserModel');
    }

    public function create()
    {
        $data = [
            'nome_razao' => filter_input(INPUT_POST, 'nome_razao', FILTER_SANITIZE_STRING),
            'cpf_cnpj' => filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_STRING),
            'rg_inscricao' => filter_input(INPUT_POST, 'rg_inscricao', FILTER_SANITIZE_STRING),
            'dataNascimento_fundacao' => filter_input(INPUT_POST, 'dataNascimento_fundacao', FILTER_SANITIZE_STRING),
            'telefone' => filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING),
            'cep' => filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING),
            'rua' => filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING),
            'bairro' => filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING),
            'numero' => filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING),
            'complemento' => filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING),
            'cidade' => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING),
            'uf' => filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING),
            'senha' => filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING),
            'senha2' => filter_input(INPUT_POST, 'senha2', FILTER_SANITIZE_STRING),
        ];

        $result = Helpers::getApiConnection('/register', $data);

        if ($result->message == $this->user::USER_CREATION_SUCCESFUL) {
            $this->view->showLoginPage([
                'message' => $result->message
            ]);
        }

        $this->view->showNewAccPage([
            'message' => $result->message
        ]);
    }

    public function login()
    {
        $data = [
            'cpf_cnpj' => filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_STRING),
            'senha' => filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING),
        ];

        $result = Helpers::getApiConnection('/login', $data);

        if ($result->message == $this->user::USER_AUTHENTICATED) {
            $_SESSION['user_id'] = $result->user_id;
            $_SESSION['username'] = Helpers::decryptData($result->username);
            $_SESSION['account'] = $result->account;
            $_SESSION['token'] = $result->token;

            Helpers::response()->redirect('/dashboard');
        }

        $this->view->showLoginPage([
            'message' => $result->message
        ]);
    }

    public function getDashboardData()
    {
        $accountData = Helpers::getApiConnection('/accountData', ['user_id' => $_SESSION['user_id']]);
        $transactions = Helpers::getApiConnection("/transactions", ['account' => $accountData->account]);

        $this->view->showDashboardPage([
            'account' => $accountData->account,
            'balance' => $accountData->saldo,
            'transactions' => $transactions->transactions
        ]);
    }

    public function logout()
    {
        session_destroy();
        Helpers::response()->redirect('/');
    }
}
