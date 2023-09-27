@extends('adminlte::page')

@section('title', 'Marcas')

@section('content_header')
    <h1> Marcas 
    <a href="{{ route('carBrands.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nova marca</a>
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
                </tr>
                </thead>
                <tbody>
                    @foreach($carBrands as $carBrand)
                        <tr>
                            <td>{{$carBrand->id}}</td>
                            <td>{{$carBrand->name}}</td>
                            <td>
                                <a href="{{ route('carBrands.edit', ['carBrand' => $carBrand->id]) }}" title="Alterar"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                <form class="d-inline" method="POST" action="{{ route('carBrands.destroy', ['carBrand' => $carBrand->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir essa marca?')">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                                    </button>
                                </form>
                                <a href="{{ route('carBrands.show', ['carBrand' => $carBrand->id]) }}" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $carBrands->links('pagination::bootstrap-4')}}
            
        </div>
</div>
@endsection 