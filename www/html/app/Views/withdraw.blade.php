@extends('templates/master')

@section('page-title')
    - Saque
@endsection

@section('content-title')
    Saque
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <form action="withdraw" method="post">
                            <div class="card-header">
                                <h5 class="m-0">Saque</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="valor">Valor a sacar:</label>
                                    <input class="form-control" type="number" name="valor" id="valor">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right">Sacar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
