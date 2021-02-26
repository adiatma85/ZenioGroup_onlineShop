<div class="container">

    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/') }}" class="text-dark">Home</a></li>
                </ol>
            </nav>
        </div>
    </div> 


    <div class="row">

        <div class="col-md-9">
            <h2>BIG SALE CERIA!!!</h2>
        </div>


        <div class="col-md-3">
            <div class="input-group mb-3">
                <input wire:model="search" type="text" class="form-control" placeholder="Search . . ." aria-label="Search"
                    aria-describedby="basic-addon1">
            </div>

            <div class="input-group mb-3">
                <input wire:model="min" type="text" class="form-control" placeholder="harga min . . ." aria-label="harga min"
                    aria-describedby="basic-addon1">
            </div>

            <div class="input-group mb-3">
                <input wire:model="max" type="text" class="form-control" placeholder="harga max . . ." aria-label="harga max"
                    aria-describedby="basic-addon1">     
            </div>
        </div>

    </div>


    

    <section class="products mb-5">


        <div class="row mt-4">
            @foreach($products as $product)

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


        <div class="row">
            <div class="col">
                {{ $products->links() }}
            </div>
        </div>


    </section>


</div>
