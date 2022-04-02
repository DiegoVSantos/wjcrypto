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

    public function showLoginPage($params = null)
    {
        echo $this->view->render('login');
    }

    public function showDashboardPage($params = null)
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('dashboard', $teste);
    }

    public function showWithdrawPage($params = null)
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('withdraw', $teste);
    }

    public function showDepositPage($params = null)
    {
        $teste = [
            'username' => 'Diego Vicente'
        ];

        echo $this->view->render('deposit', $teste);
    }

    public function showTransferPage($params = null)
    {
        echo $this->view->render('transfer');
    }
}
