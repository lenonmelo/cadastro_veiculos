@extends('adminlte::page')

@section('title', 'Visualizar marca')

@section('content_header')
    <h1>Visualizar marca</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                    {{ $carBrand->name }}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <a href="{{ route('carBrands.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
