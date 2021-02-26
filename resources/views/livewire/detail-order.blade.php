<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Order</li>
                </ol>
            </nav>
        </div>
    </div>


    
    <div class="row">
        <div class="col">
            <div class="table-responsive"> 
                <form wire:submit.prevent="konfirmasiKirim"> 
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Gambar</td>
                            <td>Nama Produk</td>
                            <td>Jumlah</td>
                            <td>varian produk</td>
                            <td>Harga</td> 
                            <td>Total Harga</td>
                            <td>Keterangan</td>
                        </tr>
                    </thead> 
                    <tbody>
                        <?php $no = 1 ?>
                        @forelse ($order_details as $order_detail) 
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                            <img src="{{ asset('storage/photos/'.$order_detail->product->gambar) }}" width="145px" height="185px">
                            </td>
                            <td>
                                {{ $order_detail->product->nama }}
                            </td> 
                            <td>{{ $order_detail->jumlah_pesanan }}</td>
                            <td>{{ $order_detail->varian }}</td>
                            <td>Rp. {{ number_format($order_detail->product->harga) }}</td>
                            <td><strong>Rp. {{ number_format($order_detail->jumlah_harga) }}</strong></td>
                            <td>
                                <strong>Total harga sudah termasuk diskon {{$order_detail->diskon}}</strong>
                            </td>
                           
                        </tr>      
                        @empty
                        <tr>
                            <td colspan="7">Data Kosong</td>
                        </tr>   
                        @endforelse
                        @if(!empty($order))
                        <tr>
                            <td colspan="6" align="right"><strong>Catatan dari pembeli : </strong></td>
                            <td align="right"><strong> *{{ $order->catatan }}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Total Harga : </strong></td>
                            <td align="right"><strong>Rp. {{ number_format($order->total_harga) }} *sudah termasuk ongkos kirim</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Alamat Pembeli : </strong></td>
                            <td align="right"><strong> {{ $order->user->alamat_lengkap}}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Kota/Kabupaten : </strong></td>
                            <td align="right"><strong> {{ $order->user->alamat}}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Jenis Service yang dipilih : </strong></td>
                            <td align="right"><strong> {{ $order->jenis_service_pengiriman}}</strong> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><strong>Nama Pembeli : </strong></td>
                            <td align="right"><strong>{{ $order->user->name}}</strong> </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="6" align="right"><strong>No hp Pembeli : </strong></td>
                            <td align="right"><strong>{{ $order->user->no_telpon}}</strong> </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="6" align="right"><strong>Status order : </strong></td>
                            <td align="right"><strong> {{ $status }}</strong> </td>
                            <td></td>
                        </tr>
 
                         
                        @if($status != 'Diterima') 
                        <tr>   

                        @if($status == 'Terbayar' && $is_refund == 0)
                        <td colspan="6" align="right">
                            <strong>Nomor Resi : </strong>
                        </td>
                        <td>
                                <input id="no_resi" type="text"
                                class="form-control @error('no_resi') is-invalid @enderror"
                                wire:model="no_resi" value="{{ old('no_resi') }}" required
                                autocomplete="no_resi" autofocus>

                                @error('no_resi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                                @enderror
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-block">Kirim Barang</button>
                        </td>
                        @endif


                        @if($status == 'Terkirim' && $is_refund == 0)
                        <td colspan="6" align="right">
                            <strong>Konfirmasi pengiriman : </strong>
                        </td>
                        <td> 
                            <button class="btn btn-danger btn-block" wire:click="konfirmasiBatal({{ $order->id }})" >
                                Batalkan Pengiriman
                            </button>
                        </td>
                        @endif

                        </tr>


                        <tr>
                            <td colspan="6" align="right"><strong>Kembalikan Pembayaran : </strong></td>
                        <td>

                        @if($is_refund == 0)
                        <a href="{{ url('Refund/'.$order->id) }}" class="btn btn-primary btn-blok">
                            Kembalikan Pembayaran
                        </a>
                        @endif
                        
                        @if($is_refund == 1)
                        <span class="badge badge-pill badge-danger">Pesanan dikembalikan</span>
                        @endif

                        </td>

                        </tr> 
                        @endif

                        @endif


                    </tbody>
                </table> 
                </form>


                
            </div>
        </div>
    </div>
</div>