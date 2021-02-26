<div class="container">




   {{-- BANNER --}}
   <div class="banner">
      <img src="{{ asset('storage/photos/slider_3.jpg') }}" width="1100px" height="380px ">
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


   {{-- Kategori Populer  --}}
   <section class="pilih-liga mt-4">
  <h4> <strong>Kategori Paling Populer </strong></h4>
      <div class="row mt-4">
         @foreach($kategori_populer as $k)
         <div class="col">
            <a href="{{ url('ProductKategori/'.$k->id) }}">
               <div class="card shadow">
                  <div class="card-body text-center">
               <img src="{{ asset('storage/photos/'.$k->gambar) }}" width="95px" height="105px">
               <div class="col-md-12">
                        <h8><strong>{{ $k->nama }}</strong> </h8>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         @endforeach 
      </div>
   </section>
 
   {{-- Product Flashsale  --}}
   <section class="products mt-5 mb-5">
      <h3>
         <strong>{{$nama_flashsale}}</strong>
         <a href="{{ url('ProductFlashsale') }}" class="btn btn-success float-right"><i class="fas fa-eye"></i> Lihat Semua </a>
      </h3>
      <div class="row mt-4">
         @foreach($product_flashsale as $product)
         <div class="col-md-3">
            <div class="card">
         
               <div class="card-body text-center">
               <div><h7>diskon {{$product->diskon}}% </h5></div>
               <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="270px">
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <h5><strong>{{ $product->nama }}</strong> </h5>
                        <h6><strong>Rp. {{ number_format($product->harga) }}</strong></h6>
                     
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <a href="{{ url('ProductDetail/'.$product->id) }}" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Detail</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach 
      </div>
   </section>


   {{-- Product Rekomendasi  --}}
   <section class="products mt-5 mb-5">
      <h3>
         <strong>Rekomendasi untuk anda </strong>
      </h3>
      <div class="row mt-4">
         @foreach($product_rekomendasi as $product)
         <div class="col-md-3">
            <div class="card">
         
               <div class="card-body text-center">
               <div><h7>diskon {{$product->diskon}}% </h5></div>
               <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="270px">
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <h5><strong>{{ $product->nama }}</strong> </h5>
                        <h6><strong>Rp. {{ number_format($product->harga) }}</strong></h6>
                     
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <a href="{{ url('ProductDetail/'.$product->id) }}" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Detail</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach 
      </div>
   </section>


   {{-- Product Terpopuler  --}}
   <section class="products mt-5 mb-5">
      <h3>
         <strong>Product Terpopuler Minggu Ini</strong>
         <a href="{{ url('ProductPopuler') }}" class="btn btn-success float-right"><i class="fas fa-eye"></i> Lihat Semua </a>
      </h3>
      <div class="row mt-4">
         @foreach($product_populer as $product)
         <div class="col-md-3">
            <div class="card">
               <div class="card-body text-center">
               <div><h7>diskon {{$product->diskon}}% </h5></div>
               <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="270px">
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <h5><strong>{{ $product->nama }}</strong> </h5>
                        <h6><strong>Rp. {{ number_format($product->harga) }}</strong></h6>
         
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <a href="{{ url('ProductDetail/'.$product->id) }}" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Detail</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </section>


   {{-- Semua Product  --}}
   <section class="products mt-5 mb-5">
      <h3>
         <strong>Semua Product </strong>
         <a href="{{ url('ProductIndex') }}" class="btn btn-success float-right"><i class="fas fa-eye"></i> Lihat Semua </a>
      </h3>
      <div class="row mt-4">
         @foreach($product_semua as $product)
         <div class="col-md-3">
            <div class="card">
               <div class="card-body text-center">
               <div><h7>diskon {{$product->diskon}}% </h5></div>
               <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="270px">
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <h5><strong>{{ $product->nama }}</strong> </h5>
                        <h6><strong>Rp. {{ number_format($product->harga) }}</strong></h6>
         
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-12">
                        <a href="{{ url('ProductDetail/'.$product->id) }}" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Detail</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </section>





</div>