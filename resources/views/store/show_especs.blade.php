@extends('layouts.mainlayout')

@section('title', 'Product')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="#">Home</a>
            E
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Macbook Pro</span>
        </div>
    </div> <!-- end breadcrumbs -->
    @if (session('status'))
        <div class="card col-md-12 alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="product-section container">
        <div class="product-section-image">
            <img src="{{url($product->getProductImage())}}">
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
                >Add to Cart
                </button>
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
