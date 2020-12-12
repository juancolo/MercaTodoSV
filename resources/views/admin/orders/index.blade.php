@extends('layouts.admin.dashboard')

@section('title', 'MercaTodo|Admin Usuarios')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang(trans('orders.view.index.page_title'))</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@lang(trans('orders.view.index.page_title'))</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

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
                               value="{{(trans('orders.view.index.search')) ,request('search')}}"
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
                <div class="container">
                    <form id="userExport" action="#">
                        <button type="submit"
                                class="btn btn-info float-right"
                                form="userExport"
                                style="padding: 10px 50px; margin-right: 10px"><i class="fa fa-download"></i>
                        </button>
                        <input type="hidden" name="search" id="search" value="{{request('search')}}">
                    </form>
                </div>
                <table class="table table-striped-dark" style="text-align:center;">
                    <thead class="table">
                    <tr class="thead-dark text-center">
                        <th scope="col">@lang(trans('orders.view.table.headers.references'))</th>
                        <th scope="col">@lang(trans('orders.view.table.headers.status'))</th>
                        <th scope="col">@lang(trans('orders.view.table.headers.user_belongs'))</th>
                        <th scope="col">@lang(trans('orders.view.table.headers.total'))</th>
                    </tr>
                    </thead>
                    <tbody>
                @forelse($orders as $order)
                    <tr style="text-align:center;">
                        <th scope="row">{{$order->reference}}</th>

                        <td>{{$order->status}}</td>
                        <td>{{$order->user->first_name}}</td>
                        <td>{{$order->total}}</td>
<!--                        <td>
                            <form action="{{route('admin.destroy', $order)}}" method="POST">
                                <a href="{{ route('admin.edit', $order)}}">
                                    <button type="button" class="btn btn-primary">Editar</button>
                                </a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Seguro desea elminar a ?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>-->
                    </tr>
                @empty
                    <div class="card">
                        <div class="card-body">
                            @lang(trans('orders.view.table.empty'))
                        </div>
                    </div>
                @endforelse
                </tbody>
            </table>
            {{$orders->appends(request()->only('search'))->links()}}
            </div>
        </div>
    </div>
    @include('partials.__export_modal')
@endsection
