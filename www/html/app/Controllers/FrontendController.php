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
        echo $this->view->render('dashboard', $params);
    }

    public function showWithdrawPage($params = [])
    {
        echo $this->view->render('withdraw', $params);
    }

    public function showDepositPage($params = [])
    {
        echo $this->view->render('deposit', $params);
    }

    public function showTransferPage($params = [])
    {
        echo $this->view->render('transfer');
    }
}
