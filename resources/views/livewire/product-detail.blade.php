<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('ProductIndex') }}" class="text-dark">Semua Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    

    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div> 
            @endif
        </div>
    </div>

 

    <div class="row">

        <div class="col-md-6">
            <div class="card gambar-product">
                <div class="card-body">
                <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="350px" height="425px">
                </div>
            </div>
        </div>

        <div class="col-md-6">
  
            <h3>
                <strong>{{ $product->nama }}</strong>
            </h3>

            <h4>
                Rp. {{ number_format($product->harga) }}
                @if($product->stok >= 1)
                <span class="badge badge-success"> <i class="fas fa-check"></i> Ready Stok : {{$product->stok}} stok </span>
                @else
                <span class="badge badge-danger"> <i class="fas fa-times"></i> Stok Habis</span>
                @endif
            </h4>
 
            <div class="row">
                <div class="col">
                    <form wire:submit.prevent="tambahKeranjang"> 
                    <table class="table" style="border-top : hidden">
                        <tr>
                            <td>kategori</td>
                            <td>:</td>
                            <td>
                            <img src="{{ asset('storage/photos/'.$product->kategori->gambar) }}" width="50px" height="65px">
                            </td>
                            <td> 
                            <h5>{{$product->kategori->nama}}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Berat</td>
                            <td>:</td>
                            <td>{{ $product->berat }}</td>
                        </tr>
                        <tr>
                            <td>Deskripsi Produk</td>
                            <td>:</td>
                            <td>{{$product->deskripsi}}</td>                        
                        </tr>

                        @if($is_available_ukuran)
                        <tr>
                            <td>Ukuran</td>
                            <td>:</td>
                            <td>
                                <select name="systems" wire:model="ukuran" class="form-control" >
                                <option value=""></option>
                                    @foreach ($v_ukuran as $u)
                                        <option value="{{$u}}">{{ $u }}</option>
                                    @endforeach
                                </select>      
                            </td>
                        </tr>
                        @endif
                        @if($is_available_warna)
                        <tr>
                            <td>Warna</td>
                            <td>:</td>
                            <td>
                                <select name="systems" wire:model="warna" class="form-control" >
                                <option value=""></option>
                                    @foreach ($v_warna as $w)
                                        <option value="{{$w}}">{{ $w }}</option>
                                    @endforeach
                                </select>      
                            </td>
                        </tr>
                        @endif
                        @if($is_available_varian_lainnya)
                        <tr>
                            <td>{{$product->varian_lainnya}}</td>
                            <td>:</td>
                            <td>
                                <select name="systems" wire:model="varian_lainnya" class="form-control" >
                                <option value=""></option>
                                    @foreach ($v_varian_lainnya as $v)
                                        <option value="{{$v}}">{{ $v }}</option>
                                    @endforeach
                                </select>      
                            </td>
                        </tr>
                        <tr>
                        @endif

                            <td>Jumlah</td>
                            <td>:</td>
                            <td>
                                <input id="jumlah_pesanan" type="number"
                                    class="form-control @error('jumlah_pesanan') is-invalid @enderror"
                                    wire:model="jumlah_pesanan" value="{{ old('jumlah_pesanan') }}" required
                                    autocomplete="jumlah_pesanan" autofocus>

                                @error('jumlah_pesanan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                                @enderror
                            </td>
                      
                        </tr> 
                    </table>

                    <div class="col-md-10">
                                <button type="submit" class="btn btn-dark btn-block">  Masukkan Keranjang</button>
                    </div>

                    </form>

                    <br>

                    <div class="col-md-10">

                     <button class="btn btn-danger btn-block" wire:click="tambahWishlist({{ $product->id }})" >
                        Masukkan Wishlist
                    </button>

                    </div>
                    
                </div>
            </div> 

        </div>
    </div>

    <br>
    <section class="products mb-5">
    <h5>Daftar Ongkos kirim yang bisa dipilih</h5>
        <div class="row mt-4">
            @forelse($result as $r)
            <div class="col-md-3">
                <div class="card">           
                    <div class="card-body text-center">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <h4><strong>{{$nama_jasa}}</strong></h4>
                                <h5><strong>{{ $r['description'] }}</strong> </h5>
                                <h6><strong>Rp. {{ number_format($r['biaya']) }}</strong></h6>
                                <h6><strong> waktu pengiriman : {{$r['etd']}} </strong></h6>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            @empty
            <span class="badge badge-pill badge-danger">Belum Tersedia</span>
            @endforelse
        </div> 
    </section> 


</div>
 