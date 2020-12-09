<header>
    <div class="header" style="justify-content: space-between; grid-auto-columns: auto">
                <ul class="top-nav container">
                    <a class="img-logo" href="{{route('client.landing')}}"><img src="{{asset('img/logo.png')}}"></a>

                <div class="top-nav-right">

                    <a href="{{route('client.landing')}}" style="color: white"><li>{{__('Home')}}</li></a>
                    <li><a href="{{route('client.product')}}" style="color: white">{{__('Buy')}}</a></li>

                    @guest()
                    <li><a href="#">Sign Up</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    @endguest

                    @auth
                        @if (Route::has('login'))

                            @if (Auth::user()->role==\App\Constants\UserRoles::ADMINISTRATOR)

                                <li>
                                    <a id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true">{{__('Admin')}}</a>
                                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{route('admin.index')}}" style="color: black;">{{__('Users Manage')}}</a>
                                        <a class="dropdown-item" href="#">{{__('Categories manage')}}</a>
                                        <a class="dropdown-item" href="{{route('product.index')}}">{{__('ProductStatus manage')}}</a>
                                    </div>
                                </li>
                            @endif

                            <li>
                                <a id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" >
                                    {{ Auth::user()->first_name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" style="color: black;"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none; color: black;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                            <li>
                                <a href="{{route('cart.index')}}" style="color: white"><i style="font-size:24px" class="fa">&#xf07a;</i></a>
                                <span class="badge badge-danger">{{\Cart::session(auth()->id())->getContent()->count()}}</span>
                            </li>
                            <li>
                                <a href="{{route('order.show')}}" style="color: white"><i style="font-size:24px" class="fa">&#xf1d8;</i></a>
                                <span class="badge badge-danger"></span>
                            </li>
                    @endauth
                </ul>
                </div>
   <!-- end top-nav -->
</header>
