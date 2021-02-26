<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('h') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keranjang') }}" class="text-dark">Keranjang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Check Out</li>
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
        <div class="col">
            <a href="{{ route('keranjang') }}" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col">
            <h4>Informasi Pembayaran</h4>
            <hr>
            <p>Untuk pembayaran silahkan dapat menggunakan beberapa metode. total harga pesanan anda adalah : <strong> Rp. {{ number_format($total_harga) }}</strong> </p>
            <div class="media">
                <div class="media-body">
                    <p>silakan checkout kemudian selesaikan pembayaran</p>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>Informasi Pengiriman</h4>
            <form wire:submit.prevent="checkout"> 
            <table class="table" style="border-top : hidden">
                <tr>
                    <td>No Telepon</td>
                    <td>:</td>
                    <td>{{$nohp}}</td>
                </tr>     
                <tr>
                    <td>Kabupaten/Kota</td>
                    <td>:</td>
                    <td>{{$alamat}}</td>
                </tr>   
                <tr>
                    <td>Alamat Lengkap</td>
                    <td>:</td>
                    <td>{{$alamat_lengkap}}</td>
                </tr>  
                <tr>
                    <td>Total yang harus dibayar</td>
                    <td>:</td>
                    <td>{{$total_harga}}</td>
                </tr>   
                <tr>
                    <td> <strong>Catatan ke penjual</strong> </td> 
                    <td>
                            <textarea id="catatan" rows="5" cols="38"
                            class="form-control @error('catatan') is-invalid @enderror"
                            wire:model="catatan" value="{{ old('catatan') }}" required
                            autocomplete="catatan" autofocus >
                            </textarea> 
                    </td>
                    <td>
                            <button type="submit" class="btn btn-success btn-block">Checkout
                            </button>
                    </td>
                </tr>                                                                            
            </table> 
            </form>
            


        </div>
    </div>
</div> 