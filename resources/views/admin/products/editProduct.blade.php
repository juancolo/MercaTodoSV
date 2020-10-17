@extends('layouts.admin.dashboard')

@section('title', 'MercaTodo|Admin Productos')

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
            <div class="container form">
                <div class="half-form">
                    <div class="half-form" >

                        <form method="post" action="{{route('product.update', $product)}}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <br>
                            <h2>Acá podrá editar los Productos</h2>

                            @if($errors->any())
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <br>
                            <div class="form-group">
                                <label class="label" for="name">{{__('Product name')}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       id="name"
                                       value="{{old( 'name', $product->name)}}"
                                       >
                                {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label for="last_name">{{__('Slug')}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="slug"
                                       id="slug"
                                       value="{{old ('slug',$product->slug)}}"
                                       placeholder="{{old('category')}}"
                                       readonly>
                                {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group">
                                <label>{{__('Category')}}</label>

                                <select class="form-control"
                                        name = "category_id">
                                    @foreach($categories as $id => $name)
                                            <option name = "category_id"
                                                    value="{{$id}}"
                                                    {{$id == old('category_id', $product->category_id) ? 'selected': ''}}
                                                    >{{$name}}</option>

                                    @endforeach

                                </select>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('old_price') ? 'has-error' : ''}} col">
                                    <label for="old_price">{{__('Old Price')}}</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{__('$')}}</div>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               id="old_price"
                                               name="old_price"
                                               value="{{$product->old_price}}"
                                               placeholder="{{__('Product old price')}}"
                                               readonly>
                                        {!! $errors->first('oldPrice', '<span class="help-block">:message</span>') !!}

                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('actual_price') ? 'has-error' : ''}} col">
                                    <label for="actualPrice">{{__('Actual Price')}}</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">{{__('$')}}</div>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               id="actual_price"
                                               name="actual_price"
                                               value="{{$product->actual_price}}"
                                               placeholder="{{__('Product actual price')}}">
                                    </div>
                                </div>
                            </div>
                        <div class="container">
                            <label>{{__('Tags')}}</label>
                            <br>

                            @foreach ($product->tags as $tagged)

                            @endforeach

                            @foreach($tags as $id => $name)

                                <div class="col-sm-3">
                                    <label class="checkbox-inline "for="tags[]">
                                        <input name="tags[]" type="checkbox" value="{{ $id }}"

                                               @foreach ($product->tags as $tagged)

                                               @if($tagged['id'] == $id) checked=checked @endif

                                                @endforeach

                                        > {{ $name }}
                                    </label>
                                </div>

                            @endforeach

                        </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                <label for="last_name">{{__('Description')}}</label>
                                <textarea type="text"
                                       class="form-control"
                                       name="description"
                                       id="description"
                                       placeholder="{{old('description')}}">
                                       {{$product->description}}
                                </textarea>
                            </div>

                            <div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}">
                                <label for="last_name">{{__('Detail')}}</label>
                                <input type="text"
                                       class="form-control"
                                       name="details"
                                       id="details"
                                       value="{{$product->details}}"
                                       placeholder="{{old('details')}}">
                            </div>

                            <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                                <label for="image">Imagen actual:
                                    <a>
                                        <img src="{{asset($product->file)}}">
                                    </a>
                                </label>
                            </div>
                            <div>
                                <label for="image">Imagen producto:</label>
                                <input type="file"
                                       name="file"
                                       id="file"
                                       value="{{$product->file}}">
                                <p class="help-block">Imagen del producto</p>
                                {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                            </div>

                            <tbody>
                            <div class="form-group">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="description">{{__('Product Status')}}</label>
                                        <select class="form-control"
                                                name="status"
                                                id="status">
                                            <option value="{{$product->status}}"> {{$product->status}}</option>
                                            <option value="{{'ACTIVO'}}"> {{__('ACTIVO')}}</option>
                                            <option value="{{'INACTIVO'}}"> {{__('INACTIVO')}}</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Modificar</button>

                                    <a class="btn btn-danger" href="{{route('product.index')}}">Cancelar</a>
                                </div>
                            </div>

                            </tbody>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

