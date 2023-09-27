@extends('adminlte::page')

@section('title', 'Modelos')

@section('content_header')
    <h1> Modelos 
    <a href="{{ route('carModels.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Novo modelo</a>
    <h1/>
@endsection
@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        <h5><i class="icon fas fa-ban"></i>Erros: </h5>
        <ul>
            <li>{{ session('error') }}</li>
        </ul>
    </div>c
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
                    <th> ID </th>
                    <th>Nome</th>
                    <th>Marca</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($carModels as $carModel)
                        <tr>
                            <td>{{$carModel->id}}</td>
                            <td>{{$carModel->name}}</td>
                            <td>{{$carModel->carBrand->name}}</td>
                            <td>
                                <a href="{{ route('carModels.edit', ['carModel' => $carModel->id]) }}" title="Alterar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                <form class="d-inline" method="POST" action="{{ route('carModels.destroy', ['carModel' => $carModel->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir esse modelo?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                                    </button>
                                </form>
                                <a href="{{ route('carModels.show', ['carModel' => $carModel->id]) }}" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $carModels->links('pagination::bootstrap-4')}}

        </div>
</div>
@endsection 