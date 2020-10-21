@extends('layouts.mainlayout')

@section('title', 'MercaTodo|Admin Editar Usuarios')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Inicio</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Editar Producto</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="container form">
        <div class="half-form">
            <div class="half-form" >

                <form method="post" action="{{route('admin.update', $category->id)}}" onreset="" >
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
                               value="{{$category->name}}"
                               placeholder="{{old('first_name')}}">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Apellidos</label>
                        <input type="text"
                               class="form-control"
                               name="last_name"
                               value="{{$category->slug}}"
                               placeholder="{{old('last_name')}}">
                    </div>


                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email"
                               class="form-control"
                               name="email"
                               value="{{$category->email}}"
                               placeholder="{{old('email')}}">
                    </div>

                        <button type="submit" class="btn btn-primary">Modificar</button>

                        <a class="btn btn-danger" href="{{route('admin.index')}}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()
