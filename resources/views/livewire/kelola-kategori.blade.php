<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Kategori</li>
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
        <div class="col-md-3">
            <a href="{{ url('PengaturanToko')}}" class="btn btn-primary btn-blok">
            Tambah Kategori
            </a>
        </div>
    </div>
    
    <br>

    <div class="row">
        <div class="col">
            <div class="table-responsive"> 
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Nama Kategori</td>
                            <td>Gambar</td>
                            <td>Jumlah Produk</td>
                            <td>Hapus</td>
                        </tr>
                    </thead> 

                    <tbody> 
                        <?php $no = 1 ?>
                        @forelse ($data_kategori as $d)
                        <tr>
                            <td>{{ $no++ }}</td>

                            <td>
                                {{ $d->nama }}
                            </td> 

                            <td>
                            <img src="{{ asset('storage/photos/'.$d->gambar) }}" width="150px" height="175px">
                            </td>

                            <?php $jumlah_produk = \App\Models\Product::where('kategori_id', $d->id)->count(); ?>
                            <td>{{ $jumlah_produk }}</td>

                            <td>
                                <button class="btn btn-danger btn-block" wire:click="destroy({{ $d->id }})" >
                                    Hapus 
                                </button> 
                            </td>

                           
                        </tr>    
                        @empty
                        <tr>
                            <td colspan="7">Kategori Kosong</td>
                        </tr>   
                        @endforelse                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>