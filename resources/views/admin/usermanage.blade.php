@extends('layouts.template')

@section('content')

    <div class="container">
        <h2 align="center">Registro de usuarios<a href="admin.create"><button type="button" class="btn btn-dark float-right" >Registrar usuarios</button></a></h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo Electrónico</th>
                <th scope="col">Opciones</th>

            </tr>
            </thead>
            <tbody>
            @foreach($users as $info)
                <tr>
                    <th scope="row">{{$info->id}}</th>

                    <td>{{$info->name}}</td>
                    <td>{{$info->email}}</td>
                    <td>


                        <form action="{{route('admin.destroy', $info->id)}}" method="POST">

                            <a href="{{ route('admin.edit', $info->id)}}"><button type="button" class="btn btn-primary">Editar</button></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea elminar?')">Eliminar</button>

                        </form>


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
