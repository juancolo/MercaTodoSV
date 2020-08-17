<header>
    <div class="header" style="justify-content: space-between; grid-auto-columns: auto">

            <a class="img-logo" href="{{route('product.index')}}"><img src="{{asset('img/logo.png')}}"></a>

                <ul class="top-nav container">
                    <li class="nav-item button"><a href="#">Home</a></li>
                    <li class="nav-item button" ><a href="#">Page 2</a></li>

                    @guest()
                    <li class= "nav-item button"><a href="#">Sign Up</a></li>
                    <li class= "nav-item button"><a href="#">Login</a></li>
                    @endguest

                    @auth
                        @if (Route::has('login'))

                            @if (Auth::user()->role=='Administrador')

                                <li class= "nav-item">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle button-white" role="button" data-toggle="dropdown" aria-haspopup="true" >Administrador <span class="caret"></span></a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{route('admin.index')}}" style="color: black;">{{__('Users Manage')}}</a>
                                        <a class="dropdown-item" href="#" style="color: black;">{{__('Categories manage')}}</a>
                                        <a class="dropdown-item" href="#" style="color: black;">{{__('Products manage')}}</a>
                                    </div>
                                </li>
                                </li>
                            @endif

                            <li class= "nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle button-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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

                    @endauth
                </ul>
            </div>

    </div> <!-- end top-nav -->
</header>
