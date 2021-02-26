<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
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
        <div class="col-md-12">
          
            <div class="alert alert-warning">
            Silakan filter data keranjang anda berdasarkan status ongkir
            </div>
          
        </div>
    </div>
    <h6>Lihat Keranjang Berdasarkan</h6>
    @if($order_status == 0)
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-success btn-block" wire:click="is_ongkir_true()" >
            Ongkir Telah Ditambahkan
            </button> 
        </div>
    </div>
    @endif

    @if($order_status == 2)
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-danger btn-block" wire:click="is_ongkir_false()" >
            Ongkir Belum Ditambahkan
            </button> 
        </div>
    </div>
    @endif

    <br>


    <div class="row">
        <div class="col">
            <div class="table-responsive"> 
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Gambar</td>
                            <td>Nama Produk</td>
                            <td>Jumlah</td>
                            <td>Harga</td> 
                            <td>Total Harga</td>
                            <td>Keterangan</td>
                            @if($order_status == 0)
                            <td>edit</td>
                            @endif
                        </tr>
                    </thead> 
                    <tbody> 
                        <?php $no = 1 ?>
                        @forelse ($order_details as $order_detail)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                            <img src="{{ asset('storage/photos/'.$order_detail->product->gambar) }}" width="200px" height="225px">
                            </td>
                            <td>
                                {{ $order_detail->product->nama }}
                            </td> 
                            <td>{{ $order_detail->jumlah_pesanan }}</td>
                            <td>Rp. {{ number_format($order_detail->product->harga) }}</td>
                            <td><strong>Rp. {{ number_format($order_detail->jumlah_harga) }}</strong></td>
                            <td>
                                <strong>Total Harga sudah termasuk diskon {{$order_detail->diskon}}</strong>
                            </td>
                            @if($order_status == 0)
                            <td>    <button class="btn btn-danger btn-block" wire:click="destroy({{ $order_detail->id }})" >
                                    Hapus
                                    </button> 
                            </td>
                            @endif
                           
                           
                        </tr>    
                        @empty
                        <tr>
                            <td colspan="7">Data Kosong</td>
                        </tr>   
                        @endforelse
                        @if($order_status == 2 && !empty($order))
                        <tr>
                            <td colspan="6"></td>
                            <td colspan="2">
                                <button class="btn btn-danger btn-block" wire:click="destroyAll()" >
                                    Hapus Semua
                                </button> 
                            </td>
                        </tr>
                        @endif
                        @if(!empty($order))
                        <tr>
                            @if($order_status == 2)
                            <td colspan="6" align="right"><strong>Total Harga (sudah termasuk ongkos kirim) : </strong></td>
                            @endif
                            @if($order_status == 0)
                            <td colspan="6" align="right"><strong>Total Harga(belum termasuk ongkos kirim) : </strong></td>
                            @endif
                            <td align="right"><strong>Rp. {{ number_format($order->total_harga) }}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Kode Unik : </strong></td>
                            <td align="right"><strong> {{ $order->unik}}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Total Yang Harus dibayarkan : </strong></td>
                            <td align="right"><strong>Rp. {{ number_format($order->total_harga) }}</strong> </td>
                            <td></td>
                        </tr> 
                        <tr>
                            
                            @if($order->status == 0)
                            @if($available_ongkir_true == 1)
                            <td colspan="6"></td>
                            <td colspan="2">
                                <button class="btn btn-primary btn-block" wire:click="gabungOngkir()" >
                                   Gabungkan Ongkos Kirim
                                </button> 
                            </td>
                            @endif
                            @if($available_ongkir_true == 0)
                            <td colspan="6"></td>
                            <td colspan="2">
                                <a href="{{ url('CekOngkir/'.$order->id) }}" class="btn btn-primary btn-blok">
                                    Tambahkan Ongkos Kirim
                                </a>
                            </td>
                            @endif
                            @endif 

                            @if($order->status == 2)
                            <td colspan="6"></td>
                            <td colspan="2">
                                <a href="{{ url('Checkout') }}" class="btn btn-success btn-blok">
                                    <i class="fas fa-arrow-right"></i> Check Out
                                </a>
                            </td>

                            <td colspan="2">
                                <a href="{{ url('CekOngkir/'.$order->id)}}" class="btn btn-primary btn-blok">
                                    <i class="fas fa-arrow-right"></i> Ubah Ongkir
                                </a>
                            </td>
                            @endif

                        </tr>
                        @endif



                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>