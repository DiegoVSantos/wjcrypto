<?php

declare(strict_types=1);

namespace WJCrypto\Controllers\Api;

use WJCrypto\Helpers;
use WJCrypto\Models\AccountModel;

class AccountApiController extends AccountModel
{
    public function getAccountData()
    {
        $data = json_decode(file_get_contents('php://input'));
        $account = parent::getAccount($data->user_id);

        Helpers::apiResponse(
            'Dados recuperados com sucesso',
            (array) $account
        );
    }

    public function withdrawApi()
    {
        $data = json_decode(file_get_contents('php://input'));
        parent::withdraw($data->account, $data->qty);

        $balance = parent::getAccountBalance($data->account);

        $message = 'Saque realizado com sucesso';

        Helpers::apiResponse(
            $message,
            [
                'account' => $data->account,
                'balance' => $balance
            ]
        );
    }

    public function depositApi()
    {
        $data = json_decode(file_get_contents('php://input'));
        parent::deposit($data->account, $data->qty);

        $balance = parent::getAccountBalance($data->account);

        $message = 'Depósito realizado com sucesso';

        Helpers::apiResponse(
            $message,
            [
                'account' => $data->account,
                'balance' => $balance
            ]
        );
    }

    public function transferApi()
    {
        $data = json_decode(file_get_contents('php://input'));
        parent::withdraw($data->sourceAccount, $data->qty);
        parent::deposit($data->targetAccount, $data->qty);

        $balance = parent::getAccountBalance($data->sourceAccount);

        $message = 'Transferencia realizada com sucesso';

        Helpers::apiResponse(
            $message,
            [
                'targetAccount' => $data->targetAccount,
                'sourceAccount' => $data->sourceAccount,
                'balance' => $balance
            ]
        );
    }

    public function transactionHistory()
    {
        $data = json_decode(file_get_contents('php://input'));
        $transactions = parent::getTransactionHistory($data->account);

        $message = "Histórico de transações extraído com sucesso";

        Helpers::apiResponse(
            $message,
            [
                'transactions' => $transactions
            ]
        );
    }
}
