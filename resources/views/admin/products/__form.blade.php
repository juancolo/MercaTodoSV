<div class="container">
    <div id="app">
        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <h2>{{__('')}}</h2>
            <div class="form-group">
                <label for="name">{{__('Name')}}</label>
                <input v-model="name"
                       class="form-control"
                       type="text"
                       name="name"
                       id="name"
                       placeholder="{{__('Product name')}}"
                       value="{{old ('name')}}">

                <label for="slug">{{__('Slug')}}</label>
                <input v-model="generateSlug"
                       class="form-control"
                       type="text"
                       name="slug"
                       id="slug"
                       placeholder="{{__('Product slug')}}"
                       value="{{old ('slug')}}">

                <div class="row">
                    <div class="col">
                        <label for="category">{{__('Old Price')}}</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{__('$')}}</div>
                            </div>
                            <input type="text"
                                   class="form-control"
                                   id="old_price"
                                   name="old_price"
                                   placeholder="{{__('Product old price')}}"
                                   value="{{old ('old_price')}}">
                        </div>
                    </div>

                    <div class="col {{ $errors->has('actual_price') ? 'has-error' : ''}}">
                        <label for="category">{{__('Actual Price')}}</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{__('$')}}</div>
                            </div>
                            <input type="text"
                                   class="form-control"
                                   id="actual_price"
                                   name="actual_price"
                                   placeholder="{{__('Product actual price')}}"
                                   value="{{old ('actual_price')}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>{{__('Category')}}</label>

                    <select class="form-control"
                            name = "category_id">
                        @foreach($categories as $category)

                            <option name = "category_id"
                                    value="{{$category->id}}">
                                {{$category->name}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="container">
                    <label for="tags[]">{{__('Tags')}}</label>
                    <br>

                    @foreach($tags as $id => $name)

                        <div class="col-sm-3">
                            <label class="checkbox-inline "for="tags[]">
                                <input name="tags[]" id="tags" type="checkbox" value="{{$id}}">
                                {{ $name}}
                            </label>
                        </div>

                    @endforeach

                </div>

                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                    <label for="last_name">{{__('Description')}}</label>
                    <textarea class="form-control"
                              name="description"
                              id="description">
                              {{old('description')}}
                                </textarea>
                </div>

                <div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}">
                    <label for="last_name">{{__('Detail')}}</label>
                    <input type="text"
                           class="form-control"
                           name="details"
                           id="details"
                           placeholder="{{__('Product details')}}"
                           value="{{old ('details')}}">
                </div>

                <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                    <label for="ProductImage">Imagen producto:</label>
                    <input type="file"
                           accept="image/x-png,image/gif,image/jpeg"
                           name="file"
                           placeholder="{{__('Product file')}}"
                           value="{{old ('file')}}">
                    <p class="help-block">Imagen del producto</p>
                    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                </div>

            </div>
            <input type="submit" value="{{__('Create a Product')}}" class="btn btn-primary float-right">
        </form>
        <hr>
    </div>
</div>
