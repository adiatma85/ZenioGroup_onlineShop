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

                <div class="card-header">{{ ('Ubah Akun') }}</div>
 
                <div class="card-body">

                    <form wire:submit.prevent="edit"> 

                        <label for="email" class="col-md-12 col-form-label text-md-left">{{ ('Email') }} </label>

                        <input id="no_telpon" type="text"
                        class="form-control @error('no_telpon') is-invalid @enderror"
                        wire:model="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>  
                        @enderror


                        <label for="old_password" class="col-md-12 col-form-label text-md-left">{{ ('Password Lama') }} </label>

                        <input id="old_password" type="password"
                        class="form-control @error('old_password') is-invalid @enderror"
                        wire:model="old_password" value="{{ old('old_password') }}" required
                        autocomplete="old_password" autofocus>

                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                        </span>  
                        @enderror
    
                        <br><br>


                        <label for="new_password" class="col-md-12 col-form-label text-md-left">{{ ('Password Baru') }} </label>

                        <input id="new_password" type="password"
                        class="form-control @error('new_password') is-invalid @enderror"
                        wire:model="new_password" value="{{ old('new_password') }}" required
                        autocomplete="new_password" autofocus>

                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>  
                        @enderror

    
                        <label for="new_password_confirm" class="col-md-12 col-form-label text-md-left">{{ ('Konfirmasi Password Baru') }} </label>

                        <input id="new_password_confirm" type="password"
                        class="form-control @error('new_password') is-invalid @enderror"
                        wire:model="new_password_confirm" value="{{ old('new_password_confirm') }}" required
                        autocomplete="new_password_confirm" autofocus>

                        @error('new_password_confirm')
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