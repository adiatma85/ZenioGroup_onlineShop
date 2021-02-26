<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Lengkapi Beberapa Data Berikut') }}</div>
 
                <div class="card-body">

                <form wire:submit.prevent="update"> 
                
                <label for="nama" class="col-md-12 col-form-label text-md-left">{{ ('Nama Produk') }} </label>

                <input id="nama" type="text"
                class="form-control @error('nama') is-invalid @enderror"
                wire:model="nama" value="{{ old('nama') }}" required
                autocomplete="name" autofocus>

                @error('nama')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>  
                @enderror


                <label for="harga" class="col-md-12 col-form-label text-md-left">{{ ('Harga Produk') }} </label>

                <input id="harga" type="number"
                class="form-control @error('harga') is-invalid @enderror"
                wire:model="harga" value="{{ old('harga') }}" required
                utocomplete="harga" autofocus>

                @error('harga')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> 
                @enderror


                <label for="stok" class="col-md-12 col-form-label text-md-left">{{ ('Stok Produk') }} </label>

                <input id="stok" type="number"
                class="form-control @error('stok') is-invalid @enderror"
                wire:model="stok" value="{{ old('stok') }}" required
                autocomplete="stok" autofocus>

                @error('stok')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> 
                @enderror
 

                <label for="berat" class="col-md-12 col-form-label text-md-left">{{ ('Berat Produk') }} </label>

                <input id="berat" type="number"
                class="form-control @error('berat') is-invalid @enderror"
                wire:model="berat" value="{{ old('berat') }}" required
                autocomplete="berat" autofocus>

                @error('berat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> 
                @enderror


                <label for="diskon" class="col-md-12 col-form-label text-md-left">{{ ('diskon(%)') }} </label>
          
                <input id="diskon" type="number"
                class="form-control @error('diskon') is-invalid @enderror"
                wire:model="diskon" value="{{ old('diskon') }}" required
                autocomplete="diskon" autofocus>

                @error('diskon')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span> 
                @enderror

                <label for="" class="col-md-12 col-form-label text-md-left">{{ ('kategori Produk') }} </label>

                <select name="systems" wire:model="kategori_id" class="form-control" >
                <option value=""></option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{$kategori->id}}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>

                @error('kategori')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span> 
                @enderror

                <label for="deskripsi" class="col-md-12 col-form-label text-md-left">{{ ('deskripsi') }} </label>

                <textarea id="deskripsi" rows="5" cols="38"
                class="form-control @error('deskripsi') is-invalid @enderror"
                wire:model="deskripsi" value="{{ old('deskripsi') }}" required
                autocomplete="deskripsi" autofocus >
                </textarea> 

                <label for="tags" class="col-md-12 col-form-label text-md-left">{{ ('tags (*gunakan spasi untuk memisahkan antar tags)') }} </label>

                <input id="tags" type="text"
                class="form-control @error('tags') is-invalid @enderror"
                wire:model="tags" value="{{ old('tags') }}" required
                autocomplete="tags" autofocus>

                @error('tags')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>  
                @enderror

                <label for="gambar" class="col-md-12 col-form-label text-md-left">{{ ('gambar produk (*maks 2 MB)') }} </label>

                <input id="" type="file" wire:model="gambar">
                @error('gambar')
                <span class="error">{{ $message }}</span>
                @enderror

                <br><br>
                <p>Varian produk <strong>*tambahkan jika produk memiliki ukuran, warna atau varian lainnya, kosongi jika tidak ada</strong></p>

                <label for="list_ukuran" class="col-md-12 col-form-label text-md-left">  <strong>{{ ('Ukuran produk') }} </strong></label>
                <p>silakan tambahkan daftar ukuran dengan menggunakan tanda <strong>'#'</strong> untuk memisahkan dengan ukuran lainnya </p>
                
                <textarea id="list_ukuran" rows="4" cols="36"
                class="form-control @error('list_ukuran') is-invalid @enderror"
                wire:model="list_ukuran" value="{{ old('list_ukuran') }}" 
                autocomplete="list_ukuran" autofocus >
                </textarea> 


                <label for="list_warna" class="col-md-12 col-form-label text-md-left">  <strong>{{ ('Warna produk') }} </strong></label>
                <p>silakan tambahkan daftar ukuran dengan menggunakan tanda <strong>'#'</strong> untuk memisahkan dengan warna lainnya </p>
                 
                <textarea id="list_warna" rows="4" cols="36"
                class="form-control @error('list_warna') is-invalid @enderror"
                wire:model="list_warna" value="{{ old('list_warna') }}" 
                autocomplete="list_warna" autofocus >
                </textarea> 
                
                <br><br>

                <p><strong>Varian lainnya</strong></p>

                <label for="varian_lainnya" class="col-md-12 col-form-label text-md-left"><strong>{{ ('Nama Varian') }} </strong></label>

                <input id="varian_lainnya" type="text"
                class="form-control @error('varian_lainnya') is-invalid @enderror"
                wire:model="varian_lainnya" value="{{ old('varian_lainnya') }}" 
                autocomplete="varian_lainnya" autofocus>

                @error('varian_lainnya')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>  
                @enderror
                <p>silakan tambahkan daftar ukuran dengan menggunakan tanda <strong>'#'</strong> untuk memisahkan dengan varian lainnya </p>
                
                <textarea id="list_varian_lainnya" rows="4" cols="36"
                class="form-control @error('list_varian_lainnya') is-invalid @enderror"
                wire:model="list_varian_lainnya" value="{{ old('list_varian_lainnya') }}" 
                autocomplete="list_varian_lainnya" autofocus >
                </textarea> 







                <br><br>
                <div class="col-md-6">
                         <button type="submit" class="btn btn-success btn-block">Edit Produk</button>
                </div>
                </form>

                   
                </div> 
            </div>
        </div>
    </div>
</div>
