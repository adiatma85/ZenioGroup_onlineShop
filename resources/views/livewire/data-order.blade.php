<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Order Pelanggan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-12">
            @if(session()->has('message'))
            <div class="alert alert-info">
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
                            <td> <strong>Status</strong></td>
                            <td><strong>Total Harga</strong></td>
                            <td>Hapus</td>
                            <td>Detail</td>
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
                                <img src="{{ asset('storage/photos/'.$pesanan_detail->product->gambar) }}" width="62px" >
                                {{ $pesanan_detail->product->nama }}
                                <br>
                                @endforeach
                            </td>
                            <td>
                                @if($pesanan->is_refund == 1)
                                <strong>Pesanan dikembalikan</strong>
                                @endif
                                @if($pesanan->status == 1 && $pesanan->is_refund == 0)
                                <strong>Pesanan telah dibayar</strong>
                                @endif
                                @if($pesanan->status == 3) 
                                <strong>Pesanan telah dikirim</strong>
                                @endif
                                @if($pesanan->status == 4)
                                <strong>Pesanan telah diterima</strong>
                                @endif
                            </td> 
                            <td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                            <td> <button class="btn btn-danger btn-block" wire:click="destroy({{ $pesanan->id }})" >
                               Hapus
                            </button></td>
                            <td>
                            <a href="{{ url('DetailOrder/'.$pesanan->id) }}" class="btn btn-warning btn-block"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                             <td colspan="7">Data Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    
</div>