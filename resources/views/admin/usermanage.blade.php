@extends('layouts.mainlayout')

@section('title', 'MercaTodo|Admin Usuarios')

@section('content')

    <div class="container">
        <br>
        <h2 align="left">Registro de usuarios<a href="admin.create"><button type="button" class="btn btn-dark float-right" >Registrar usuarios</button></a></h2>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Correo Electrónico</th>
                <th scope="col">Rol</th>
                <th scope="col">Opciones</th>

            </tr>
            </thead>
            <tbody>
            @foreach($users as $info)
                <tr>
                    <th scope="row" >{{$info->id}}</th>

                    <td>{{$info->first_name}}</td>
                    <td>{{$info->last_name}}</td>
                    <td>{{$info->email}}</td>
                    <td>{{$info->role}}</td>

                    <td>


                        <form action="{{route('admin.destroy', $info->id)}}" method="POST">

                            <a href="{{ route('admin.edit', $info->id)}}"><button type="button" class="btn btn-primary">Editar</button></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro desea elminar a {{$info->first_name}} {{$info->last_name}}?')">Eliminar</button>

                        </form>


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users}}
    </div>
@endsection
