<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                Pastikan alamat dan data diri anda benar, jika belum silakan lakukan perubahan
            </div> 
        </div>
    </div> 

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="col-md-12">
                    <div class="row">
                         <div class="col">

                            <table class="table" style="border-top : hidden">
                                <tr>
                                    <td> <strong> No Telepon </strong> </td>
                                    <td>:</td>
                                    <td>{{$no_telpon}}</td>
                                </tr>
                                <tr>
                                    <td> <strong> Kota/Kabupaten Tujuan </strong> </td>
                                    <td>:</td>
                                    <td>{{$alamat}}</td>
                                </tr>
                                <tr>
                                    <td> <strong> Alamat Lengkap </strong> </td>
                                    <td>:</td>
                                    <td>{{$alamat_lengkap}}</td>
                                </tr>                                                                                        
                            </table> 
                            <div>
                                <a href="{{ url('DataUser') }}" class="btn btn-success btn-blok">
                                Edit Data
                                </a>
                            </div> 
                            <br>
                        </div> 
                    </div>
                </div> 
            </div> 
        </div>
    </div>
              

    <section class="products mb-5">
        <div class="row mt-4">
        <?php $i = 0; ?>
        @forelse($result as $r)
            <div class="col-md-3">
                <div class="card"> 
                    <div class="card-body text-center">
                        <div><h5>{{$nama_jasa}}</h5></div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <h5><strong>{{ $r['biaya'] }}</strong> </h5>
                                <h6><strong>{{ $r['etd'] }}</strong></h6>      
                                <h6><strong>{{ $r['description'] }}</strong></h6>  
                            </div>
                        </div>
                        <div class="row mt-2">
                            <button class="btn btn-success btn-block" wire:click="tambahBiayaPengiriman({{ $i }})" >
                                Tambah Sebagai Ongkir
                            </button>
                        </div>
                    </div>
                </div> 
            </div>
            <?php $i++; ?>
            @endforeach
        </div> 
    </section>
</div>








 








