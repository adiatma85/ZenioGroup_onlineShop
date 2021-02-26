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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Data dan Administrasi Toko') }}</div>
 


                <div class="card-body"> 

                <form wire:submit.prevent="tambahKategori"> 
                
                <h6>Tambah Kategori</h6>

                <label for="no_telpon" class="col-md-12 col-form-label text-md-left">{{ ('Nama Kategori') }} </label>

                <input id="nama_kategori" type="text"
                class="form-control @error('nama_kategori') is-invalid @enderror"
                wire:model="nama_kategori" value="{{ old('nama_kategori') }}" required
                autocomplete="nama_kategori" autofocus> 

                @error('nama_kategori')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror 
 

                <label for="gambar_kategori" class="col-md-12 col-form-label text-md-left">{{ ('Gambar Kategori') }} </label>

                <input id="gambar_kategori" type="file" wire:model="gambar_kategori">
                @error('gambar')
                    <span class="error">{{ $message }}</span>
                @enderror

                <br><br>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success btn-block">Tambah Kategori</button>
                </div>
                </form>
          
                </div> 

                <div class="card-body"> 


                <br>
                
                <h6>Data Toko</h6>

                <form wire:submit.prevent="save_update"> 

                <label for="no_flashsale" class="col-md-12 col-form-label text-md-left">{{ ('Nama Flashsale') }} </label>

                <input id="nama_flashsale" type="text"
                class="form-control @error('nama_flashsale') is-invalid @enderror"
                wire:model="nama_flashsale" value="{{ old('nama_flashsale') }}" required
                autocomplete="nama_flashsale" autofocus> 

                @error('nama_flashsale')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror 

                <label for="no_telepon" class="col-md-12 col-form-label text-md-left">{{ ('No Telepon') }} </label>

                <input id="no_telepon" type="text"
                class="form-control @error('no_telepon') is-invalid @enderror"
                wire:model="no_telepon" value="{{ old('no_telepon') }}" required
                autocomplete="no_telepon" autofocus> 

                @error('no_telepon')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror 

                <label for="jasa_pengiriman" class="col-md-12 col-form-label text-md-left">{{ ('Jasa Pengiriman') }} </label>

                <select name="jasa_pengiriman" wire:model="jasa_pengiriman" class="form-control" >
                <option value="">-PILIH JASA PENGIRIMAN-</option>
                <option value="jne">JNE</option>
                <option value="pos">POS INDONESIA</option>
                <option value="tiki">TIKI</option>
                </select>


                <label for="provinsi" class="col-md-12 col-form-label text-md-left">{{ ('Provinsi') }} </label>

                <select name="provinsi" wire:model="provinsi_id" class="form-control" >
                <option value="0">-PILIH PROVINSI-</option>
                @forelse ($daftarProvinsi as $p)
                <option value="{{$p['province_id']}}">{{ $p['province'] }}</option>
                @empty
                <option value="0">Provinsi tidak ada</option>
                @endforelse
                </select>


                <label for="kota" class="col-md-12 col-form-label text-md-left">{{ ('Kota') }} </label>

                <select name="kota" wire:model="kota_id" class="form-control" >
                <option value="">-PILIH KABUPATEN/KOTA-</option>
                @forelse ($daftarKota as $k)
                <option value="{{$k['city_id']}}">{{ $k['city_name'] }}</option>
                @empty
                <option value="">PILIH KABUPATEN/KOTA</option>
                @endforelse
                </select>

                <br><br>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Data</button>
                </div>
                </form>

                </div> 
            </div>
        </div>
    </div>
</div>
