@extends('adminlte::page')

@section('title', 'Novo veículo')

@section('content_header')
<h1>Novo veículo</h1>
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i>Erros:</h5>
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => 'vehicles.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        {{ csrf_field() }}
        <div class="form-group row">
            {!! Form::label('name', 'Nome:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('car_brand_id', 'Marcas:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('car_brand_id', ['' => 'Selecione uma marca'] + $carBrands->pluck('name', 'id')->toArray(), old('car_brand_id'), ['id' => 'car_brand_id', 'class' => 'form-control' . ($errors->has('car_brand_id') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('car_model_id', 'Modelo:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('car_model_id', ['' => 'Selecione um modelo'], old('car_model_id'), ['class' => 'form-control' . ($errors->has('car_model_id') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('year', 'Ano:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('year', old('year'), ['class' => 'form-control' . ($errors->has('year') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('mileage', 'Quilometragem:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('mileage', old('mileage'), ['class' => 'form-control' . ($errors->has('mileage') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('price', 'Preço:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('price', old('price'), ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('image', 'Imagem:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::file('image') !!}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                {!! Form::submit('Cadastrar', ['class' => 'btn btn-success']) !!}
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function () {
        // Aplica a máscara para valores monetários
        $('#price').mask('000.000.000,00', { reverse: true });

        //Aplica a máscara no campo quilometragem
        $('#mileage').mask('000.000.000', { reverse: true });

        $('#car_brand_id').on('change', function () {
            filterCarModels();
        });

        filterCarModels();
    });

    function filterCarModels(){
        var carBrandId = $("#car_brand_id").val();
        if (carBrandId) {
            // Faça uma requisição AJAX para obter os modelos com base na marca selecionada
            $.ajax({
                url: '/carModelByCarBrand/' + carBrandId, // Substitua pelo URL correto
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Limpe as opções existentes no dropdown de modelos
                    $('#car_model_id').empty();
                    // Adicione a opção padrão
                    $('#car_model_id').append('<option value="">Selecione um modelo</option>');
                    // Adicione as opções dos modelos com base nos dados recebidos
                    $.each(data, function (key, value) {
                        $('#car_model_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            // Limpe o dropdown de modelos se nenhuma marca for selecionada
            $('#car_model_id').empty();
            $('#car_model_id').append('<option value="">Selecione uma marca</option>');
        }
    }
</script>
@endsection
