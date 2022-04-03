<?php

namespace WJCrypto\Controllers;

use WJCrypto\Helpers;
use WJCrypto\Models\UserModel;

class UserController extends UserModel
{
    /**
     * @var FrontendController $view
     */
    private $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = Helpers::getContainer('FrontendController');
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
        return parent::createUser($data);
    }

    public function getLastUserCreated()
    {
        return parent::lastCreatedUser();
    }

    public function login()
    {
        $data = [
            'cpf_cnpj' => filter_input(INPUT_POST, 'cpf_cnpj', FILTER_SANITIZE_STRING),
            'senha' => filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING),
        ];

        if (!parent::userExists($data['cpf_cnpj'])) {
            echo $this->view->showLoginPage()
        }
        password_verify($pass, )
    }
}
