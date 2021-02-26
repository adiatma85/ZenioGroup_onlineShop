<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>



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
        <div class="col-md-6">
            <div class="card">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col">
                            
                                <table class="table" style="border-top : hidden">
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{$data_user->email}}</td>
                                    </tr>
 
                                    <tr>
                                        <td>Kota/Kabpupaten</td>
                                        <td>:</td>
                                        <td>{{$data_user->alamat}}</td>
                                    </tr>

                                    <tr>
                                        <td>Alamat Lengkap</td>
                                        <td>:</td>
                                        <td>{{$data_user->alamat_lengkap}}</td>
                                    </tr>

                                    <tr>
                                        <td>No Telepon</td>
                                        <td>:</td>
                                        <td>{{$data_user->no_telpon}}</td>                        
                                    </tr> 

                                    <tr>
                                        <td>No Rekening</td>
                                        <td>:</td>
                                        <td>{{$data_user->no_rekening}}</td>                        
                                    </tr>

                                    <tr>
                                        <td>Nama Bank</td>
                                        <td>:</td>
                                        <td>{{$data_user->nama_bank}}</td>
                                    </tr>
                                </table> 
                                                
                            </div> 
                        </div>
                     </div>
            </div>
            <br>

            @if($stop != 1)
            <div>
                <a href="{{ url('DataUser') }}" class="btn btn-success btn-blok">
                Edit Data
                </a>
            </div> 
            @endif


            <br>
            <div>
                <a href="{{ url('EditAkun') }}" class="btn btn-danger btn-blok">
                Ubah Password
                </a>
            </div> 
 
        </div>
        
     </div>
</div> 