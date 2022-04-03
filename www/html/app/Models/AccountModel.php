<?php

namespace WJCrypto\Models;

use WJCrypto\Helpers;

class AccountModel
{

    /**
     * @var DbModel
     */
    private $conn;

    public function __construct()
    {
        $this->conn = Helpers::getContainer('Database');
    }

    public function createAccount($data)
    {
        $insert = $this->conn->insert('accounts', $data);
        if ($insert->rowCount()) {
            return true;
        }

        return false;
    }
}
