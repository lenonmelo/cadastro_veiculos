@extends('adminlte::page')

@section('title', 'Veículos')

@section('content_header')
    <h1>Veículos 
    <a href="{{ route('vehicles.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Novo veículo</a>
    </h1>
@endsection

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        <h5><i class="icon fas fa-ban"></i>Erros:</h5>
        <ul>
            <li>{{ session('error') }}</li>
        </ul>
    </div>
@endif  

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif 

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Quilometragem</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{$vehicle->id}}</td>
                        <td>{{$vehicle->name}}</td>
                        <td>{{$vehicle->carBrand->name}}</td>
                        <td>{{$vehicle->carModel->name}}</td>
                        <td>{{$vehicle->year}}</td>
                        <td>{{ number_format($vehicle->mileage, 0, '', '.') }}</td>
                        <td>{{ number_format($vehicle->price, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" title="Alterar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                            <form class="d-inline" method="POST" action="{{ route('vehicles.destroy', ['vehicle' => $vehicle->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir esse veículo?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                                </button>
                            </form>
                            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle->id]) }}" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $vehicles->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
