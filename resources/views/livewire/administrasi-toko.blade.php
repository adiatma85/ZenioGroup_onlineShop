<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>



<div class="container">

    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>  
            @endif
        </div>
    </div> 

        <div class="row justify-content-center">
            <div class="col-md-6"> 
                <div class="card">
                    <div class="col-md-12">
                        <div class="row">
                             <div class="col">                 
                                <table class="table" style="border-top : hidden">

                                    <tr>
                                        <td>Kota/Kabupaten</td>
                                        <td>:</td>
                                        <td>{{$data_toko->nama_kota}}</td>
                                    </tr>

                                    <tr>
                                        <td>Jasa Pengiriman</td>
                                        <td>:</td>
                                        <td>{{$data_toko->jasa_pengiriman}}</td>
                                    </tr>

                                    <tr>
                                        <td>No Telepon</td>
                                        <td>:</td>
                                        <td>{{$data_toko->no_telepon}}</td>                        
                                    </tr> 

                                    <tr>
                                        <td>Nama Flashsale</td>
                                        <td>:</td>
                                        <td>{{$data_toko->nama_flashsale}}</td>                        
                                    </tr>

                                    <tr>
                                        <td>Jumlah Kategori</td>
                                        <td>:</td>
                                        <td>{{$jumlah_kategori}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Jumlah Produk</td>
                                        <td>:</td>
                                        <td>{{$jumlah_produk}}</td>
                                    </tr>
                                </table>                                      
                            </div> 
                        </div>
                    </div>
                </div>
                <br>
                <div>
                    <a href="{{ url('PengaturanToko') }}" class="btn btn-success btn-blok">
                    Ubah Data Toko
                    </a>
                </div> 
                     
            </div>   
       </div>

       <section class="products mb-5">
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card"> 
                        <div class="card-body text-center">
                            <div class="col-md-12">
                                <a href="{{ url('Myproduct') }}" class="btn btn-danger btn-blok">
                                    Kelola Produk
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-3">
                    <div class="card"> 
                        <div class="card-body text-center">
                            <div class="col-md-12">
                                <a href="{{ url('ProductPopuler') }}" class="btn btn-danger btn-blok">
                                   Product Terpoluler
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-3">
                    <div class="card"> 
                        <div class="card-body text-center">
                            <div class="col-md-12">
                                <a href="{{ url('DataOrder') }}" class="btn btn-danger btn-blok">
                                    Kelola Order
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-3">
                    <div class="card"> 
                        <div class="card-body text-center">
                            <div class="col-md-12">
                                <a href="{{ url('KelolaKategori') }}" class="btn btn-danger btn-blok">
                                    Daftar Kategori
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
        </section>




</div> 