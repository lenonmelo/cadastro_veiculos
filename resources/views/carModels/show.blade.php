@extends('adminlte::page')

@section('title', 'Visualizar Modelo')

@section('content_header')
    <h1>Visualizar Modelo</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                    {{ $carModel->name }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Marca</label>
                <div class="col-sm-10">
                    {{ $carModel->carBrand->name }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <a href="{{ route('carModels.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
