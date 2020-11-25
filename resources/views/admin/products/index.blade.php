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
                            <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
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

                @if($errors->any())
                    <div class="alert alert-danger {{session('alert') ?? 'alert-info'}}">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
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
                            <button class="btn btn-navbar" style="margin-top: 40px;">
                                <i class="fa fa-search" style="text-shadow: 0 0 3px #000;"></i>
                                <button class="btn btn-primary" href="{{route('product.index')}}"
                                        style="margin-top: 40px">{{__('Clean')}}</button>
                            </button>
                        </div>
                    </div>
                </form>
                <div>
                    <h2>{{__('Products')}}<a href="{{route('product.create')}}">

                            <button type="button"
                                    class="btn btn-dark float-right"
                                    style="border-radius: 10px;">{{__('Create Product')}}</button>
                        </a>

                        <button type="button"
                                class="btn btn-info float-right"
                                data-toggle="modal"
                                data-target="#exportModal"
                                data-route="{{route('product.export')}}"
                                style="padding: 10px 50px; margin-right: 10px"><i class="fa fa-download"></i></button>
                        <a type="button"
                           href="{{route('product.import')}}"
                           class="btn btn-info float-right"
                           data-toggle="modal"
                           data-target="#import"
                           style="padding: 10px 50px; margin-right: 10px"><i class="fa fa-upload"></i></a>
                    </h2>
                </div>
                @if($products->count() > 0)
                    <table class="table-striped">
                        <thead class="table">
                        <tr class="thead-dark text-center">
                            <th scope="col">#</th>
                            <th scope="col">{{__('images')}}</th>
                            <th scope="col">{{__('Product')}}</th>
                            <th scope="col">{{__('Category')}}</th>
                            <th scope="col">{{__('Price')}}</th>
                            <th scope="col">{{__('Options')}}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr style="text-align:center;">
                                <th scope="row">{{$product->id}}</th>

                                <td>
                                    <img src="{{asset($product->getProductImage())}}" class="w-50 h-50" alt="">
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{$product->presentPrice()}}</td>


                                <td>
                                    <div>
                                        <form action="{{route('product.destroy', $product)}}" method="POST"
                                              style=" width: 300px">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('¿Seguro desea elminar a {{$product->name}} ?')">
                                                Eliminar
                                            </button>
                                            <a class="btn btn-primary" href="{{ route('product.edit', $product)}}">Editar</a>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination" style="justify-content: center">{{$products}}</div>
                @else
                    <div class="text-center">
                        <h3>{{__('There is no products to show')}}</h3>
                    </div>
                @endif
            </div>

        </div>
    @include('partials.__import_modal')
    @include('partials.__export_modal')
@endsection
