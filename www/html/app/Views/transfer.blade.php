@extends('templates/master')

@section('page-title')
    - Transferência
@endsection

@section('content-title')
    Transferência
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <form action="transferPost" method="post">
                            <div class="card-header">
                                <h5 class="m-0">Transferir</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="conta">Conta de Destino:</label>
                                            <input class="form-control" type="text" name="conta" id="conta" placeholder="00000-1">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="valor">Valor a transferir:</label>
                                            <input class="form-control" type="text" name="valor" id="valor">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right">Transferir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
