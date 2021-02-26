<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Lengkapi Beberapa Data Berikut') }}</div>
 
                <div class="card-body">

                <form wire:submit.prevent="store"> 
                <label for="no_telpon" class="col-md-12 col-form-label text-md-left">{{ ('No Telpon') }} </label>

                <input id="no_telpon" type="text"
                class="form-control @error('no_telpon') is-invalid @enderror"
                wire:model="no_telpon" value="{{ old('no_telpon') }}" required
                autocomplete="no_telpon" autofocus>

                @error('no_telpon')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror


                <label for="no_rekening" class="col-md-12 col-form-label text-md-left">{{ ('No Rekening Aktif') }} </label>

                <input id="no_rekening" type="text"
                class="form-control @error('no_telpon') is-invalid @enderror"
                wire:model="no_rekening" value="{{ old('no_rekening') }}" required
                autocomplete="no_rekening" autofocus>

                @error('no_rekening')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror


                <label for="nama_bank" class="col-md-12 col-form-label text-md-left">{{ ('Nama Bank') }} </label>

                <input id="nama_bank" type="text"
                class="form-control @error('nama_bank') is-invalid @enderror"
                wire:model="nama_bank" value="{{ old('nama_bank') }}" required
                autocomplete="nama_bank" autofocus>

                @error('nama_bank')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror 
 

                <label for="provinsi" class="col-md-12 col-form-label text-md-left">{{ ('Silakan pilih Provinsi Anda') }} </label>

                <select name="provinsi" wire:model="provinsi_id" class="form-control" >
                <option value="0">-PILIH PROVINSI-</option>
                @forelse ($daftarProvinsi as $p)
                <option value="{{$p['province_id']}}">{{ $p['province'] }}</option>
                @empty
                <option value="0">Provinsi tidak ada</option> 
                @endforelse
                </select>


                <label for="kota" class="col-md-12 col-form-label text-md-left">{{ ('Silakan pilih Kota Anda') }} </label>

                <select name="kota" wire:model="kota_id" class="form-control" >
                <option value="">-PILIH KABUPATEN/KOTA-</option>
                @forelse ($daftarKota as $k)
                <option value="{{$k['city_id']}}">{{ $k['city_name'] }}</option>
                @empty
                <option value="">PILIH KABUPATEN/KOTA</option>
                @endforelse
                </select>
                

                <label for="alamat_lengkap" class="col-md-12 col-form-label text-md-left">{{ ('Alamat Lengkap') }} </label>

                <textarea id="alamat_lengkap" rows="5" cols="38"
                class="form-control @error('alamat_lengkap') is-invalid @enderror"
                wire:model="alamat_lengkap" value="{{ old('alamat_lengkap') }}" required
                autocomplete="alamat_lengkap" autofocus >
                </textarea>

                @error('alamat_lengkap')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror 


                <br><br>
                <div class="col-md-6">
                         <button type="submit" class="btn btn-success btn-block">Simpan Data</button>
                </div>
                </form>

                   
                </div> 
            </div>
        </div>
    </div>
</div>
