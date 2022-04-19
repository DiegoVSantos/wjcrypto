<?php

namespace WJCrypto\Models;

use WJCrypto\Helpers;

class UserModel
{
    /**
     * @var DbModel $conn
     */
    private $conn;

    public function __construct()
    {
        $this->conn = Helpers::getContainer('Database');
    }

    protected function createUser($data)
    {
        if ($this->userExists($data['cpf_cnpj'])) {
            throw new \Exception("Usuário já existente com o CPF / CNPJ informado");
        }

        if ($data['senha'] != $data['senha2']) {
            throw new \Exception("As senhas informadas não conferem");
        }

        unset($data['senha2']);
        $data['senha'] = password_hash($data['senha'], PASSWORD_ARGON2I);

        $insert = $this->conn->insert('users', $data);
        if (!$insert->rowCount()) {
            throw new \Exception("Erro ao inserir usuário na base de dados");
        }
    }

    protected function userExists($cpfCnpj)
    {
        return (bool) $this->conn->select('users', ["cpf_cnpj = '$cpfCnpj'"])->rowCount();
    }

    protected function getUserData($cpfCnpj)
    {
        return $this->conn->select('users', ["cpf_cnpj = '$cpfCnpj'"])->fetchObject();
    }

    protected function lastCreatedUser()
    {
        return $this->conn->connection()->lastInsertId();
    }
}
