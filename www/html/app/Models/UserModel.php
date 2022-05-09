<?php

declare(strict_types=1);

namespace WJCrypto\Models;

use WJCrypto\Helpers;

class UserModel
{
    public const USER_ALREADY_EXISTS = "Usuário já existente com o CPF / CNPJ informado";
    public const USER_AUTHENTICATED = "Usuário OK";
    public const USER_DATABASE_ERROR = "Erro ao inserir usuário na base de dados";
    public const USER_NOT_FOUND = "Usuário não encontrado na base de dados";
    public const USER_WRONG_PASSWORD = "Senha incorreta";
    public const USER_WRONG_PASSWORD_CONFIRMATION = "As senhas informadas não conferem";
    public const USER_CREATION_SUCCESFUL = "Usuário cadastrado com sucesso";

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
        $data->nome_razao = Helpers::encryptData($data->nome_razao);
        $data->cpf_cnpj = Helpers::encryptData($data->cpf_cnpj);
        $data->rg_inscricao = Helpers::encryptData($data->rg_inscricao);
        $data->dataNascimento_fundacao = Helpers::encryptData($data->dataNascimento_fundacao);
        $data->telefone = Helpers::encryptData($data->telefone);
        $data->cep = Helpers::encryptData($data->cep);
        $data->rua = Helpers::encryptData($data->rua);
        $data->bairro = Helpers::encryptData($data->bairro);
        $data->numero = Helpers::encryptData($data->numero);
        $data->complemento = Helpers::encryptData($data->complemento);
        $data->cidade = Helpers::encryptData($data->cidade);
        $data->uf = Helpers::encryptData($data->uf);

        if ($this->userExists($data->cpf_cnpj)) {
            throw new \Exception(self::USER_ALREADY_EXISTS);
        }

        if ($data->senha != $data->senha2) {
            throw new \Exception(self::USER_WRONG_PASSWORD_CONFIRMATION);
        }

        unset($data->senha2);
        $data->senha = password_hash($data->senha, PASSWORD_ARGON2I);

        $insert = $this->conn->insert('users', (array)$data);
        if (!$insert->rowCount()) {
            throw new \Exception(self::USER_DATABASE_ERROR);
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

    protected function setAuthenticationToken($user_id): string
    {
        $data['token'] = base64_encode(random_bytes(16));
        $this->conn->update('users', $data, 'id', $user_id);
        return $data['token'];
    }

    public function getAuthenticationToken($token)
    {
        return (bool) $this->conn->select('users', ["token = '$token'"])->rowCount();
    }
}
