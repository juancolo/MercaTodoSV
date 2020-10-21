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

                    <form method="post" action="{{route('product.update', $product->slug)}}" onreset="" >
                        @method('PUT')
                        @csrf
                        <br>
                        <h2>Acá podrá editar los Productos</h2>
                        <br>
                        <div class="form-group">
                            <label class="label" for="first_name">{{__('Product name')}}</label>
                            <input type="text"
                                   class="form-control"
                                   name="name"
                                   id="name"
                                   value="{{$product->name}}"
                                   placeholder="{{old('name')}}">
                        </div>

                        <div class="form-group">
                            <label for="last_name">{{__('Product category')}}</label>
                            <input type="text"
                                   class="form-control"
                                   name="category"
                                   value="{{$product->category->name}}"
                                   placeholder="{{old('category')}}">
                        </div>

                        <tbody>
                        <div class="form-group">
                            <div class="col">
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Estado usuario</label>
                                    </div>
                                </td>

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

