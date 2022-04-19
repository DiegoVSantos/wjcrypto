@extends('templates/master')

@section('page-title')
    - Depósito
@endsection

@section('content-title')
    Depósito
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if (isset($message))
                <div class="alert alert-success">
                    <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <form action="depositPost" method="post">
                            <div class="card-header">
                                <h5 class="m-0">Depositar</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="valor">Valor a depositar:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input class="form-control" type="number" step="0.01" name="valor" id="valor">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right">Depositar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
