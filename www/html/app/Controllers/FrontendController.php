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
        echo $this->view->render('sampleContent');
    }
}
