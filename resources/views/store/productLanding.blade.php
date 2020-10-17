
<body>
    <header>
        @extends('layouts.mainlayout')
        @section('content')

            <div class="hero container">
                <div class="hero-copy">
                    <h1>Laravel Ecommerce Demo</h1>
                    <p>Includes multiple products, categories, a shopping cart and a checkout system with Stripe integration.</p>
                    <div class="text-center button-container">
                        <a href="#" class="button">Blog Post</a>
                        <a href="#" class="button">GitHub</a>
                    </div>
                </div> <!-- end hero-copy -->


                <div class="hero-image" align="left">
                    <img src="{{asset('img/macbook-pro-laravel.png')}}">
                </div> <!-- end hero-image -->
            </div> <!-- end hero -->
            @yield('header')
    </header>
    <div class="featured-section">

        <div class="container">
            <h1 class=" text-center">CSS Grid Example</h1>

            <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic.</p>

            <div class="text-center button-container">
                <a href="#" class="button">Featured</a>
                <a href="#" class="button">On Sale</a>
            </div>



    <div class="row" style="padding-top: 40px">
            @foreach($products as $product)
                <div class="col-md-4 shop-grid" style="padding-top: 40px">
                    <a href="#"><div class="text-center">Name: {{$product->name}}</div></a>
                        <div class="image">

                                    @if ($product->file)

                                <a href="">
                                        <img src="{{$product->file}}" class="w-100">
                                        <div class="overlay">
                                        <div class="detail"> View Detail</div>
                                        </div>
                                </a>
                                    @endif
                        </div>
                                <a class="text-center">{{$product->description}}</a>
                                <a class="text-center">{{$product->category->name}}</a>
                                <div class="text-center">Price: {{$product->presentPrice()}}</div>
                    <br>
                </div> <!-- end products -->
            @endforeach
    </div>
        <div class="text-center button-container" align="center">
            <a href="#" class="button">View more products</a>
        </div>

    </div> <!-- end container -->
    @yield('product')
</div> <!-- end featured-section -->

<div class="blog-section">
    <div class="container">
        <h1 class="text-center">From Our Blog</h1>

        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic.</p>

        <div class="blog-posts">
            <div class="blog-post" id="blog1">
                <a href="#"><img src="/img/blog1.png" alt="Blog Image"></a>
                <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi, tenetur numquam ipsam reiciendis.</div>
            </div>
            <div class="blog-post" id="blog2">
                <a href="#"><img src="/img/blog2.png" alt="Blog Image"></a>
                <a href="#"><h2 class="blog-title">Blog Post Title 2</h2></a>
                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi, tenetur numquam ipsam reiciendis.</div>
            </div>
            <div class="blog-post" id="blog3">
                <a href="#"><img src="/img/blog3.png" alt="Blog Image"></a>
                <a href="#"><h2 class="blog-title">Blog Post Title 3</h2></a>
                <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi, tenetur numquam ipsam reiciendis.</div>
            </div>
        </div>
    </div> <!-- end container -->
    @yield('blog')
</div> <!-- end blog-section -->
@endsection('content')
</body>

