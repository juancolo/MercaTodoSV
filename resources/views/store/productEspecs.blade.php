@extends('layouts.mainlayout')

@section('title', 'Product')

@section('content')

       <div class="breadcrumbs">
        <div class="container">
            @if(Cart::session(auth()->id()))
            {{Cart::session(auth()->id())->getTotal()}}
            @endif
            <a href="#">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Macbook Pro</span>
        </div>
    </div> <!-- end breadcrumbs -->
       @if (session('status'))
           <div class="alert alert-success">
               {{ session('status') }}
           </div>
       @endif
    <div class="product-section container">
        <div class="product-section-image">
            {{dd($product)}}
            @if ($product->file)

                <img src="{{$product->file}}" class="embed-responsive" alt="product">

            @endif
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{$product->name}}</h1>
            <div class="product-section-subtitle">{{$product->details}}</div>
            <div class="product-section-price">{{ $product->presentPrice()}}</div>

            <p>
                {!! $product->description !!}
            </p>

            <p>&nbsp;</p>

                <form action="{{route('cart.store', $product)}}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit"
                            class="button button-plain"
                    >Add to Cart</button>
                </form>
        </div>

    </div> <!-- end product-section -->

    <div class="might-like-section">
        <div class="container">
            <h2>You might also like...</h2>
            <div class="might-like-grid">
                <div class="might-like-product">
                    <img src="{{ asset('img/macbook-pro.png') }}" alt="product">
                    <div class="might-like-product-name">MacBook Pro</div>
                    <div class="might-like-product-price">$2499.99</div>
                </div>
                <div class="might-like-product">
                    <img src="{{ asset('img/macbook-pro.png') }}" alt="product">
                    <div class="might-like-product-name">MacBook Pro</div>
                    <div class="might-like-product-price">$2499.99</div>
                </div>
                <div class="might-like-product">
                    <img src="{{ asset('img/macbook-pro.png') }}" alt="product">
                    <div class="might-like-product-name">MacBook Pro</div>
                    <div class="might-like-product-price">$2499.99</div>
                </div>
                <div class="might-like-product">
                    <img src="{{ asset('img/macbook-pro.png') }}" alt="product">
                    <div class="might-like-product-name">MacBook Pro</div>
                    <div class="might-like-product-price">$2499.99</div>
                </div>
            </div>
        </div>
    </div>


@endsection
