<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Lengkapi Beberapa Data Berikut') }}</div>
 
                <div class="card-body">

                <form wire:submit.prevent="save_refund"> 
                <label for="pesan" class="col-md-12 col-form-label text-md-left">{{ ('Pesan Kepada Pembeli') }} </label>

                <textarea id="pesan" rows="5" cols="38"
                class="form-control @error('alamat_lengkap') is-invalid @enderror"
                wire:model="pesan" value="{{ old('pesan') }}" required
                autocomplete="pesan" autofocus >
                </textarea>

                @error('pesan')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>  
                @enderror  

                <br>

                <label for="bukti_refund" class="col-md-12 col-form-label text-md-left">{{ ('Bukti Pengembalian Pembayaran') }} </label>
                <input id="bukti_refund" type="file" wire:model="bukti_refund">

                @error('gambar')
                <span class="error">{{ $message }}</span>
                @enderror

                <br><br>
                <div class="col-md-6">
                         <button type="submit" class="btn btn-success btn-block">Kembalikan</button>
                </div>
                </form>

                   
                </div> 
            </div>
        </div>
    </div>
</div>
