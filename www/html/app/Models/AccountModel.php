<?php

declare(strict_types=1);

namespace WJCrypto\Models;

use WJCrypto\Helpers;

class AccountModel
{
    public const ACCOUNT_CREATION_FAILED = "Erro ao criar sua conta";

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

    protected function getAccount($user_id)
    {
        return $this->conn->select('accounts', ["user_id = $user_id"])->fetchObject();
    }

    protected function getAccountByAccNum($account)
    {
        return $this->conn->select('accounts', ["account = '$account'"])->fetchObject();
    }

    protected function getAccountBalance($account)
    {
        $account = $this->getAccountByAccNum($account);
        return $account->saldo;
    }

    protected function deposit($account_num, $qty, $log = true)
    {
        $account = $this->getAccountByAccNum($account_num);

        $balance = $account->saldo;
        $finalBalance = $balance + $qty;

        $data = [
            'account' => $account_num,
            'saldo' => $finalBalance
        ];

        $this->conn->update('accounts', $data, 'account', $account_num);

        if ($log) {
            $this->saveTransactionHistory(2, $account_num, $qty, $finalBalance);
        }
    }

    protected function withdraw($account_num, $qty, $log = true)
    {
        $account = $this->getAccountByAccNum($account_num);

        $balance = $account->saldo;
        $finalBalance = $balance - $qty;

        $data = [
            'account' => $account_num,
            'saldo' => $finalBalance
        ];
        $this->conn->update('accounts', $data, 'account', $account_num);

        if ($log) {
            $this->saveTransactionHistory(1, $account_num, $qty, $finalBalance);
        }
    }

    protected function transfer($targetAccount, $qty)
    {
        $account_num = $_SESSION['account'];

        $this->withdraw($account_num, $qty, false);
        $this->deposit($targetAccount,$qty, false);
    }

    /**
     * @param $transaction_id
     * 1 - Withdraw 2 - Deposit 3 - Transfer
     * @param $account
     * @param $qty
     * @param $finalBalance
     * @param $targetAccount
     * @return void
     */
    protected function saveTransactionHistory($transaction_id, $account, $qty, $finalBalance, $targetAccount = null)
    {
        $dateNow = new \DateTime('now');

        $data = [
            'date' => $dateNow->format('Y-m-d H:i:s'),
            'account' => $account,
            'transaction_id' => $transaction_id,
            'value' => $qty,
            'final_balance' => $finalBalance
        ];

        $this->conn->insert('transaction_histories', $data);

        if ($targetAccount) {
            $transferData = [
                'transaction_history_id' => $this->conn->connection()->lastInsertId(),
                'target_account' => $targetAccount
            ];

            $this->conn->insert('transfer_histories', $transferData);
        }
    }

    protected function getTransactionHistory($account)
    {
        return $this->conn->select('transaction_histories', ["account = '$account'"], "id DESC")->fetchAll(\PDO::FETCH_OBJ);
    }
}
