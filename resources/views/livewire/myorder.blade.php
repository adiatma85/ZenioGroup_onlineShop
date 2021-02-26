<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
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

 
    <h5>Lihat Berdasarkan</h5> 

    @if($is_refund == 0) 
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-success btn-block" wire:click="is_refund_true()" >
            Pembayaran dikembalikan
            </button> 
        </div>
    </div>
    @endif

    @if($is_refund == 1)
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-primary btn-block" wire:click="is_refund_false()" >
            Pesanan Dikirim
            </button> 
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal Pesan</td>
                            <td>Nama Produk</td>
                            <td><strong>Status</strong></td>
                            @if($is_refund == 0)
                            <td>Nomor Resi</td>
                            @endif
                            <td>Total Harga</td>
                            @if($is_refund == 1)
                            <td>Bukti Refund</td>
                            <td>Pesan</td>
                            @endif
                            @if($is_refund == 0)
                            <td>Konfirmasi</td>
                            @endif
                            <td>Hapus</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        @forelse ($orders as $pesanan)
                        <tr>  
                            <td>{{ $no++ }}</td>
                            <td>{{ $pesanan->created_at }}</td>
                            <td>
                                <?php $pesanan_details = \App\Models\Order_detail::where('order_id', $pesanan->id)->get(); ?>
                                @foreach ($pesanan_details as $pesanan_detail)
                                {{ $pesanan_detail->product->nama }}
                                <br><br>
                                @endforeach
                            </td>

 
                            @if($pesanan->status == 3)
                            <td>
                                <strong>Pesanan telah dikirim</strong>    
                            </td> 
                            @endif

                            @if($is_refund == 1)
                            <td>  
                                <strong>Pesanan dibatalkan</strong>
                            </td>
                            @endif

                            @if($pesanan->status == 4)
                            <td>  
                                <strong>Pesanan diterima</strong>
                            </td>
                            @endif

                            @if($is_refund == 0)
                            <td>{{$pesanan->no_resi}}</td>
                            @endif

                            <td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>

                            @if($is_refund == 1)
                            <td><img src="{{ asset('storage/photos/'.$pesanan->bukti_refund) }}" width="250px" height="300"></td>
                            <td>{{$pesanan->pesan}}</td>
                            @endif


                            @if($is_refund == 0)

                            @if($pesanan->status != 4)
                            <td>
                                <button class="btn btn-success btn-block" wire:click="konfirmasiTerima({{ $pesanan->id }})" >
                                    Konfirmasi telah diterima
                                </button>
                            </td>
                            @endif

                            @if($pesanan->status == 4)
                            <td>
                                <span class="badge badge-pill badge-info">Pesanan telah diterima</span>
                            </td>
                            @endif

                            @endif



                            <td> 
                                <button class="btn btn-danger btn-block" wire:click="destroy({{ $pesanan->id }})" >
                                    Hapus
                                </button>
                            </td>
                             
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Data Kosong</td>
                        </tr>
                        @endforelse
                        <div class="row"> 
                            <div class="col">
                             {{ $orders->links() }}
                              </div>
                        </div>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>