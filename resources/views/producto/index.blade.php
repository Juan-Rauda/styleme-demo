@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Productos registrados') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('productos.pdf') }}" class="btn btn-success btn-sm float-right"
                                    data-placement="right">
                                    {{ __('Generar PDF de productos') }}
                                </a>
                            </div>

                            <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Create nuevo producto') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Stock</th>
                                        <th>Precio</th>
                                        <th>Imagen</th>
                                        <th>Categoria</th>
                                        <th>Código QR</th>
                                        <th>Acciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->descripcion }}</td>
                                            {{-- <td>{{ $producto->stock }}</td> --}}
                                            <td class="text-center text-white">
                                                <span class="badge {{ $producto->stock >= 10 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $producto->stock }}
                                                </span>
                                            </td>
                                            <td>{{ $producto->precio }}</td>
                                            <td>
                                                <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}"
                                                    style="max-width: 100px;">
                                            </td>
                                            <td>{{ $producto->categoria->nombre }}</td>

                                            <td>
                                                {{-- {!! QrCode::size(75)->generate($producto->nombre) !!} --}}
                                            </td>

                                            <td>
                                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('productos.show', $producto->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('productos.edit', $producto->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $productos->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Agrega estilos personalizados para el paginado aquí */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination li {
            margin: 0 5px;
            list-style: none;
            display: inline-block;
        }

        .pagination li a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #3490dc;
            color: #ffffff;
            border-radius: 5px;
        }

        .pagination li.active a {
            background-color: #007bff;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
