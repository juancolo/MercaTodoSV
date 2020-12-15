@extends('layouts.admin.dashboard')

@section('title', 'MercaTodo|Admin Usuarios')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{__('User Administrator')}}</h1>
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
        <!-- /.content-header -->

        <div class="card">
            <div class="container">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{route('admin.index', 'search')}}" method="GET" class="col-6">
                    <div class="input-group">
                        <input type="text"
                               class="form-control form-control-navbar"
                               id="search"
                               name="search"
                               placeholder="{{__('Search for users')}}"
                               value="{{request('search')}}"
                               aria-label="search"
                               style="margin-top: 40px">
                        <div class="button-group">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" style="margin-top: 32px;">
                                    <i class="fa fa-search" style="text-shadow: 0 0 3px #000;"></i>
                                    <a class="btn btn-primary" href="{{route('admin.index')}}">{{__('Clean')}}</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="container">
                    <form id="userExport" action="{{route('user.export', 'search')}}">
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
                        <th scope="col">{{__('#')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Last Name')}}</th>
                        <th scope="col">{{__('Email')}}</th>
                        <th scope="col">{{__('Role')}}</th>
                        <th scope="col">{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr style="text-align:center;">
                            <th scope="row">{{$user->id}}</th>

                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>
                                <form action="{{route('admin.destroy', $user)}}" method="POST">
                                    <a href="{{ route('admin.edit', $user)}}">
                                        <button type="button" class="btn btn-primary">Editar</button>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Seguro desea elminar a {{$user->first_name}} {{$user->last_name}}?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$users->appends(request()->only('search'))->links()}}
            </div>
        </div>
    </div>
    @include('partials.__export_modal')
@endsection
