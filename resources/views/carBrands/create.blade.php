@extends('adminlte::page')

@section('title', 'Nova Marca')

@section('content_header')
    <h1> Nova Marca <h1/>
@endsection
@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i>Erros: </h5>
            
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'carBrands.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                {{ csrf_field() }}
                <div class="form-group row">
                    {!! Form::label('name', 'Nome:*', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-3">
                        {!! Form::text('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        {!! Form::submit('Cadastrar', ['class' => 'btn btn-success']) !!}
                        <a href="{{ route('carBrands.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection 