@extends('adminlte::page')

@section('title', 'Visualizar Veículo')

@section('content_header')
    <h1>Visualizar Veículo</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <img src="/images/{{ $vehicle->image }}" alt="Imagem do Veículo" class="img-fluid" width="350">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nome:</label>
            <div class="col-sm-10">
                {{ $vehicle->name }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Marca:</label>
            <div class="col-sm-10">
                {{ $vehicle->carBrand->name }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Modelo:</label>
            <div class="col-sm-10">
                {{ $vehicle->carModel->name }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Ano:</label>
            <div class="col-sm-10">
                {{ $vehicle->year }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Quilometragem:</label>
            <div class="col-sm-10">
                {{ $vehicle->mileage }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Preço:</label>
            <div class="col-sm-10">
                R$ {{ number_format($vehicle->price, 2, ',', '.') }}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection
