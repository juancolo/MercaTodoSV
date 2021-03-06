@extends('layouts.admin.dashboard')

@section('title', 'MercaTodo|Admin Editar Usuarios')

@section('content')
    {{$active = \App\Constants\UserStatus::ACTIVE}}
    {{$inactive = \App\Constants\UserStatus::INACTIVE}}
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
                            <li class="breadcrumb-item active">{{__('User Editor')}}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="card">
            <div class="container form">
                <div class="half-form">
                    <div class="half-form">

                        <form method="post" action="{{route('admin.update', $user)}}" onreset="">
                            @method('PUT')
                            @csrf
                            <br>
                            <h2>Acá podrá editar los usuarios</h2>
                            <br>
                            <div class="form-group">
                                <label class="label" for="first_name">Nombre</label>
                                <input type="text"
                                       class="form-control"
                                       name="first_name"
                                       value="{{$user->first_name}}"
                                       placeholder="{{old('first_name')}}">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Apellidos</label>
                                <input type="text"
                                       class="form-control"
                                       name="last_name"
                                       value="{{$user->last_name}}"
                                       placeholder="{{old('last_name')}}">
                            </div>


                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       value="{{$user->email}}"
                                       placeholder="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <div class="col">
                                    <th for="status">@lang('Status')</th>
                                    <td>
                                        <select name="status"
                                                id="status"
                                                class="form-control">
                                            <option name="status"
                                                    value="{{$active}}"
                                                {{$active ==  $user->status ? 'selected': ''}}
                                            >{{\App\Constants\ProductStatus::STATUSES[0]}}</option>
                                            <option name="status"
                                                    value="{{$inactive}}"
                                                {{$inactive == $user->status ? 'selected': ''}}
                                            >{{\App\Constants\ProductStatus::STATUSES[1]}}</option>
                                        </select>
                                    </td>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col">
                                    <th> Opciones de usuario</th>
                                    <td>
                                        <label for="">Rol</label>
                                        <select name="role_id"
                                                id="role_id"
                                                class="form-control">

                                            <option hidden="" value={{$user->role}}>{{$user->role}}</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Cliente">Cliente</option>
                                        </select>
                                    </td>

                                    <button type="submit" class="btn btn-primary">Modificar</button>
                                    <a class="btn btn-danger" href="{{route('admin.index')}}">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection()
