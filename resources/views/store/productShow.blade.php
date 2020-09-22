@extends('layouts.mainlayout')

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                <li><a href="#">Laptops</a></li>
                <li><a href="#">Desktops</a></li>
                <li><a href="#">Mobile Phones</a></li>
                <li><a href="#">Tablets</a></li>
                <li><a href="#">TVs</a></li>
                <li><a href="#">Digital Cameras</a></li>
                <li><a href="#">Appliances</a></li>
            </ul>

            <h3>By Price</h3>
            <ul>
                <li><a href="#">$0 - $700</a></li>
                <li><a href="#">$700 - $2500</a></li>
                <li><a href="#">$2500+</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <h1>Laptops</h1>
            <div class="container">

                <form action="{{route('client.product', 'search')}}" method="GET" class="col-6">
                    <div class="input-group input-group-sm">

                        <input type="text"
                               class="form-control form-control-navbar"
                               id="search"
                               name="search"
                               placeholder="{{__('Search')}}"
                               value="{{request('search')}}"
                               aria-label="Search">

                        @error('search')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 shop-grid" style="padding-top: 40px">
                        <a href="#"><div class="text-center">Name: {{$product->name}}</div></a>
                        <div class="image">

                            @if ($product->file)

                                <a href="{{route('client.product.specs', $product->slug)}}">
                                    <img src="{{$product->file}}" class="w-100">
                                    <div class="overlay">
                                        <div class="detail"> View Detail</div>
                                    </div>
                                </a>
                            @endif
                        </div>

                        <a class="text-center">{{$product->description}}</a>
                        <div class="text-center">Price: {{$product->presentPrice()}}</div>
                        <br>

                    </div> <!-- end products -->
                @endforeach
            </div>
            <div class="pagination" style="justify-content: center; padding-top: 40px">
                {{$products->appends(request()->only('search'))->links()}}
            </div>
        </div>
    </div>

@endsection
