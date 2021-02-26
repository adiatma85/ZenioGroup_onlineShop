<div>
    <nav class="navbar navbar-expand-md navbar-light bg-warning">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Zenio<strong>Group</strong> 
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ url('/') }}"> <strong> Home</strong></a>
                    </li>


                    <li class="nav-item dropdown"> 

                    
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong> Daftar Kategori</strong>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($Kategoris as $k)
                            <a class="dropdown-item"
                                href="{{ url('ProductKategori/'.$k->id) }}">{{ $k->nama }}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('ProductIndex') }}">Semua Kategori</a>
                        </div>


                    </li>

                   
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                   
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">  <strong>{{ __('Login') }}</strong></a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><strong>{{ __('Register') }}</strong></a>
                    </li>
                    @endif
                    @else
                    @if(Auth::user()->level == 1 )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('AdministrasiToko') }}"><strong>Administrasi Toko</strong></a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Mycheckout') }}"><strong>Data Order Saya</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('Myorder') }}"><strong>Belanja</strong></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('ProductWishlist') }}">
                        <strong>Wishlist</strong><i class="fas fa-shopping-bag"></i>
                            @if($jumlah_wishlist !==0)
                            <span class="badge badge-success">{{ $jumlah_wishlist }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('keranjang') }}">
                        <strong>Keranjang</strong> <i class="fas fa-shopping-bag"></i>
                            @if($jumlah_pesanan !==0)
                            <span class="badge badge-success">{{ $jumlah_pesanan }}</span>
                            @endif
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('ProfilUser') }}">
                        <strong> Akun Saya </strong> <i class="fas fa-shopping-bag"></i>
                            <span class="badge badge-primary">{{Auth::user()->name}} </span>
                        </a>
                    </li>





                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <strong> {{ 'Auth' }} </strong><span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>


                    </li>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>