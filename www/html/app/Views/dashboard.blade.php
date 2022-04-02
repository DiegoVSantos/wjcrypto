@extends('templates/master')

@section('page-title')
    - Dashboard
@endsection

@section('content-title')
    Tela Inicial
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4>Dados da Conta</h4>
                            <p>Conta: 1234</p>
                            <p>Agencia: 1234-5</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>Seu Saldo</h4>
                            <p>R$ 123,45</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Histórico de Transações</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Special title treatment</h6>

                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
