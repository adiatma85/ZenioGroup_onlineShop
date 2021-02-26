<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                {{ 'pesanan yang sudah diproses akan dimasukkan pada halaman belanja, silakan dicek!!!' }}
            </div>
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
 

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal Pesan</td>
                            <td>Nama Produk</td>
                            <td>Total Harga</td>
                            <td>Status Order</td>                            
                            <td>Batalkan</td> 
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

 
                            <td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>

                            @if($pesanan->is_pay > 0)
                            <td >
                                <a href="{{ url('Payment/'.$pesanan->id) }}" class="btn btn-primary btn-blok">
                                    Lihat Status
                                </a>
                            </td>
                            @endif

                            @if($pesanan->is_pay == 0)
                            <td >
                                <a href="{{ url('Payment/'.$pesanan->id) }}" class="btn btn-primary btn-blok">
                                    Pilih Pembayaran
                                </a>
                            </td>
                            @endif 

                            @if($pesanan->is_pay != 2)
                            <td> 
                                <button class="btn btn-danger btn-block" wire:click="destroy({{ $pesanan->id }})" >
                                    Batalkan
                                </button>
                            </td>
                            @endif

                            @if($pesanan->is_pay == 2)
                            <td> 
                                <strong>{{'Pembayaran berhasil'}}</strong>
                            </td>
                            @endif
                
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