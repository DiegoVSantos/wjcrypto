@section('sidebar')
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">WJCrypto</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">Olá, {{$_SESSION['username']}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="dashboard" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <p>
                            Tela Inicial
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="withdraw" class="nav-link">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>
                            Saque
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="deposit" class="nav-link">
                        <i class="fas fa-money-bill-wave"></i>
                        <p>
                            Depósito
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="transfer" class="nav-link">
                        <i class="fas fa-exchange-alt"></i>
                        <p>
                            Transferência
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@show