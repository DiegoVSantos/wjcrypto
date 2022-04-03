<?php

namespace WJCrypto\Controllers;

use Jenssegers\Blade\Blade;
use WJCrypto\Helpers;

class FrontendController
{
    private Blade $view;

    public function __construct()
    {
       $this->view = Helpers::getContainer('Blade');
    }

    public function showLoginPage($params = [])
    {
        echo $this->view->render('login', $params);
    }

    public function showNewAccPage($params = [])
    {
        echo $this->view->render('newAcc', $params);
    }

    public function showDashboardPage($params = [])
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('dashboard', $teste);
    }

    public function showWithdrawPage($params = [])
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('withdraw', $teste);
    }

    public function showDepositPage($params = [])
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('deposit', $teste);
    }

    public function showTransferPage($params = [])
    {
        echo $this->view->render('transfer');
    }
}
