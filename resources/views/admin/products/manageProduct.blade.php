@extends('layouts.admin.dashboard')

@section('title', 'MercaTodo|Admin Usuarios')

@section('content')

           <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">{{__('Product Administrator')}}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">{{__('User Administrator')}}</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>


    <div class="card">
        <div class="container">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif


            <form action="{{route('product.index', 'search')}}" method="GET" class="col-6">

                <div class="input-group">
                    <input type="text"
                           class="form-control form-control-navbar"
                           id="search"
                           name="search"
                           placeholder="{{__('Search for products')}}"
                           value="{{request('search')}}"
                           aria-label="search"
                           style="margin-top: 40px">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" style="margin-top: 40px">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <h2>Productos<a href="{{route('product.create')}}">

                    <button type="button" class="btn btn-dark float-right" >Crear producto</button></a></h2>
        <table class="table-striped">
            <thead class="table">
                <tr class="thead-dark text-center">
                    <th scope="col">#</th>
                    <th scope="col">imagen</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Opciones</th>

                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr style="text-align:center;">
                    <th scope="row" >{{$product->id}}</th>

                    <td>
                        <a href="{{route('client.product.specs', $product->slug)}}">
                            <img src="{{asset($product->file)}}" class="w-50 h-50" alt="">
                        </a>
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->presentPrice()}}</td>

                    <td>
                        <form action="{{route('product.destroy', $product->slug)}}" method="POST" style=" width: 300px">
                            <a href="{{ route('product.edit', $product->slug)}}"><button type="button" class="btn btn-primary">Editar</button></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro desea elminar a {{$product->slug}} ?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
            <div class="pagination" style="justify-content: center">{{$products}}</div>
    </div>



@endsection
