@extends('layouts.template')

@section('content')

    <div style="width:800px; margin:0 auto;" class="container margin:auto">
        <div class="row">
            <div class="column-sm-6" >
                <h2>Acá podrá editar los usuarios</h2>
                <form method="post" action="{{route('admin.update', $user->id)}}" onreset="" >
                    @method('PUT')
                    @csrf
                    <div class="form-group" align="center">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name"  value="{{$user->name}}" placeholder="Ingrese el nombre del usuario">
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="Ingrese el correo del usuario">
                    </div>

                    <div class="form-group">

                        <label for="" >Rol</label>
                        <select name="role_id" id="InputRole_id" class="form-control" value="Usuario">

                            <option hidden=""  value={{$user->role}}>{{$user->role}}</option>
                            <option value="Administrador">Administrado</option>
                            <option value="Usuario">Usuario</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Modificar</button>

                        <a class="btn btn-danger" href="{{route('admin.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()
