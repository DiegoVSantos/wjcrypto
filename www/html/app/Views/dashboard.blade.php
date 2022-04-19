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
                            <p>Conta: {{ $account }}</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4>Seu Saldo Atual</h4>
                            <p>R$ {{ $balance }}</p>
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
                            <h3 class="card-title">Histórico de Transações</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Transação</th>
                                    <th>Valor da Transação</th>
                                    <th>Saldo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)

                                    <tr>
                                        <td>{{$transaction->date}}</td>
                                        @switch($transaction->transaction_id)
                                            @case(1)
                                                <td>Saque</td>
                                                <td class="text-danger">-R$ {{$transaction->value}}</td>
                                                @break
                                            @case(2)
                                                <td>Depósito</td>
                                                <td class="text-success">+R$ {{$transaction->value}}</td>
                                                @break
                                            @default
                                                <td>R$ {{$transaction->value}}</td>
                                        @endswitch
                                        <td>{{$transaction->final_balance}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>02/02/2022</td>
                                    <td>Dummy Depósito</td>
                                    <td class="text-success">+R$ 7,77</td>
                                    <td>R$ 777,00</td>
                                </tr>
                                <tr>
                                    <td>03/02/2022</td>
                                    <td>Dummy Saque</td>
                                    <td class="text-danger">-R$ 7,77</td>
                                    <td>R$ 777,00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
