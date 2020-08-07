@extends('layouts.mainlayout')

@section('content')
<div class="container">
        <div class="row">
            <form method="POST" action="{{route('product.store')}}" >
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="name">Nombre del producto</label>
                    <input type="text" class="form-control" name="name"  value="" placeholder="{{old('name')}}">
                </div>

                <div class="form-group">
                    <label for="email">Slug del producto</label>
                    <input type="email" class="form-control" name="slug" value="" placeholder="{{old('slug')}}">
                </div>

                <div class="form-group">
                    <label for="email">Detalle del producto</label>
                    <input type="email" class="form-control" name="details" value="" placeholder="{{old('details')}}">
                </div>

                <div class="form-group">
                    <label for="email">Descripción del producto</label>
                    <input type="email" class="form-control" name="description" value="" placeholder="{{old('description')}}">
                </div>

                <div class="price">
                    <label for="email">Precio del producto</label>
                    <input type="email" class="form-control" name="price" value="" placeholder="{{old('price')}}">
                </div>

                <div class="form-group">
                    <label for="email">Categoría del producto</label>
                    <input type="email" class="form-control" name="category" value="" placeholder="{{old('category')}}">
                </div>
            </form>
        </div>
</div>
@endsection ('content')
