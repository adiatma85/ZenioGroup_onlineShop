<?php

namespace App\Http\Livewire;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Pengaturan_toko;
use App\Models\User_activity;
use App\Models\Tags_point;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Kavist\RajaOngkir\RajaOngkir;
 
class ProductDetail extends Component
{

    public $product;
    public $produk_terkait  = [];
    public $ongkir;
    public $jumlah_pesanan;
    public $nama_jasa;
    public $result  = [];
    private $apiKey = "4b747e804c0428bb51f9129db3384fa8";
    //varian konfirmasi atribut 
    public $is_available_ukuran = false, $is_available_warna = false, $is_available_varian_lainnya = false;
    //atribut varian
    public $ukuran,$warna,$varian_lainnya;
    public function mount($id) 
    {
        #mengambil data produk
        $productDetail  = Product::find($id);
        if(!empty($productDetail))
        { 
            $this->product  = $productDetail;
        }
        else
        {
            return redirect()->to('');
        }

        #varian produk

        //warna
        $warna  = json_decode($productDetail->list_warna,true);
        if(count($warna) >= 1)
        {
            if($warna[0] != 'null')
            {
                $this->is_available_warna = true;
            }
        }
       
        //varian_lainnya
        $varian_lainnya         = $productDetail->varian_lainnya;
        $list_varian_lainnya    = json_decode($productDetail->list_varian_lainnya,true);
        if($varian_lainnya != 'null' && count($list_varian_lainnya) >= 1)
        {
            if($list_varian_lainnya[0] != 'null')
            {
                $this->is_available_varian_lainnya = true;
            }
        }
      
        //ukuran
        $ukuran  = json_decode($productDetail->list_ukuran,true);
        if(count($ukuran) >= 1)
        {
            if($ukuran[0] != 'null')
            {
                $this->is_available_ukuran = true;
            }
        }
      

        //memproses tags point per produk untuk rekomendasi produk
        if(Auth::user())
        {
            $user_activity  = User_activity::where('user_id',Auth::user()->id)->first();
            if(!empty($user_activity))
            {
                if($user_activity->is_active == 1)
                { 
                    //memberi point setiap tags ke tags_point
                    $tags   = explode(" ",$productDetail->tags);
                    for($i=0; $i<count($tags); $i++)
                    {
                        $tags_point = Tags_point::where('user_id',Auth::user()->id)->where('tags','like','%'.$tags[$i].'%')->first();
                        if(!empty($tags_point))
                        {
                            $tags_point->tags_point    += 2;
                            $tags_point->update(); 
                        }
                        else
                        {
                            //create tags point
                            Tags_point::create(
                                [
                                    'user_id'           => Auth::user()->id,
                                    'tags'              => $tags[$i],
                                    'tags_point'        => 2,
                                    'tags_point_temp'   => 0  
                                ]
                            );
                        } 
                    }
                }
                else
                {
                    $user_activity->activity_point  += 2;
                    //memberi point setiap tags ke tags_point_temp
                    $tags   = explode(" ",$productDetail->tags);
                    for($i=0; $i<count($tags); $i++)
                    {
                        $tags_point = Tags_point::where('user_id',Auth::user()->id)->where('tags','like','%'.$tags[$i].'%')->first();
                        if(!empty($tags_point))
                        {
                            $tags_point->tags_point_temp    += 2;
                            $tags_point->update(); 
                        }
                        else
                        {
                            //create tags point
                            Tags_point::create(
                                [
                                    'user_id'           => Auth::user()->id,
                                    'tags'              => $tags[$i],
                                    'tags_point'        => 0,
                                    'tags_point_temp'   => 2       
                                ]
                            );
                        }
                    }
 

                    //melakukan pengecekkan apakah user_activity dikatakan aktif
                    if($user_activity->activity_point >= 5)
                    {
                        //aktifkan 
                        $user_activity->is_active   = true;
                     
                        //mengambil semua data tags_point_user yang tags_point_temp tidak 0
                        $tags_point_user = Tags_point::where('user_id',Auth::user()->id)
                                                     ->get();

                        //menimpakan point yang di tags_point_temp ke tags_point
                        foreach ($tags_point_user as $row)
                        {
                            if($row->tags_point == 0 && $row->tags_point_temp == 0)
                            {
                                continue;
                            }
                            $tags_point                  = Tags_point::where('id',$row->id)->first();
                            $tags_point->tags_point      = $tags_point->tags_point/2;
                            $tags_point->tags_point     += $tags_point->tags_point_temp;
                            $tags_point->tags_point_temp = 0;
                            $tags_point->update();
                        }
                    }
                    //mengupdate user_activity
                    $user_activity->update();
                }
            }
        }
      

        //mengambil data ongkir per produk
        if(Auth::user())
        {
            if(Auth::user()->kota_id != 0)
            {
                //mengambil data toko
                $data_toko = Pengaturan_toko::where('id','!=',0)->first();
                $rajaOngkir = new RajaOngkir($this->apiKey);
                $cost       = $rajaOngkir->ongkosKirim([
                    'origin'        => $data_toko->kota_id,     // ID kota/kabupaten asal di sini saya isi malang kota : 256 sebagai lokasi asal toko
                    'destination'   => Auth::user()->kota_id,      // ID kota/kabupaten tujuan
                    'weight'        => $productDetail->berat,   // berat barang dalam gram
                    'courier'       => $data_toko->jasa_pengiriman // kebetulan admin rumahnya deket jne
                ])->get();     
                $this->nama_jasa = $cost[0]['name'];     
                foreach ($cost[0]['costs'] as $row)
                {
                    $this->result[] = array(
                        'description'   => $row['description'],
                        'biaya'         => $row['cost'][0]['value'],
                        'etd'           => $row['cost'][0]['etd']
                    );
                }
            }
            else
            {
                session()->flash('message','lengkapi data alamat anda terlebih dahulu untuk mengetahui biaya pengiriman');
            }
        }  
        else
        {
            session()->flash('message','login terlebih dahulu untuk mengetahui biaya pengiriman');
        }
        //mengambil data produk terkait(belum final)
        $this->produk_terkait = Product::where('kategori_id',$productDetail->kategori_id)->get();
        //memberi point terhadap tags
    }

    public function tambahKeranjang()
    {
        //validasi
        $this->validate(
            [
                'jumlah_pesanan'    => 'required'
            ] 
        ); 
 
        //validasi varian produk
        if($this->is_available_ukuran && !$this->ukuran)
        {
            session()->flash('message','silakan tambahkan ukuran produk');
            return;
        }
        
        if($this->is_available_warna && !$this->warna)
        {
            session()->flash('message','silakan tambahkan warna produk');
            return;
        }

        if($this->is_available_varian_lainnya && !$this->varian_lainnya)
        {
            session()->flash('message','silakan lengkapi dulu varian produk');
            return;
        }


        //jika pesanan kurang dari 1, maka tidak bisa
        if($this->jumlah_pesanan < 1)
        {
            session()->flash('message','Masukkan Jumlah Pesanan minimal 1');
            return;
        }


        //jika user belum login, maka tidak bisa memasukkan data ke keranjang dan akan dikembalikan ke login
        if(!Auth::user())
        {
            session()->flash('message','Anda harus login terlebih dahulu');
            return redirect()->route('login');
        }


        //pengecekkan stok
        if($this->product->stok - $this->jumlah_pesanan < 0)
        {
            session()->flash('message','stok produk telah habis');
            return;
        }
           
        //menghitung total harga dengan dikon
        $total_harga    = $this->jumlah_pesanan * ($this->product->harga - (($this->product->harga *$this->product->diskon) / 100 ) );

        //menngecek apakah user mempunyai data order yang belum dicheckout atau statusnya masih 0
        $order          = Order::where('user_id',Auth::user()->id)->where('status',0)->first();
        if(empty($order))
        {
            //dibuatkan data order
            Order::create(
                [
                    'user_id'       => Auth::user()->id,
                    'total_harga'   => $total_harga,
                    'status'        => 0
                ]
            );
            $order          = Order::where('user_id',Auth::user()->id)->where('status',0)->first();
            $order->kode    = 'Belanja-'.$order->id."-".Auth::user()->id;
            $order->unik    = $order->id."-".mt_rand(1,9999)."-".Auth::user()->id;
            $order->update();
                 
        }
        else
        {
            $order->total_harga = $order->total_harga + $total_harga;
            $order->update();
        }

        if(!empty($order))
        {
            //menambah varian
            $varian = '';
            if($this->ukuran)
            {
                $varian .= $this->ukuran.", "; 
            }
            if($this->warna)
            {
                $varian .= $this->warna.", "; 
            }
            if($this->varian_lainnya)
            {
                $varian .= $this->varian_lainnya;
            }
            //dd($varian);
            Order_detail::create(
                [
                    'jumlah_pesanan'    => $this->jumlah_pesanan,
                    'jumlah_harga'      => $total_harga,
                    'varian'            => $varian,
                    'product_id'        => $this->product->id,
                    'order_id'          => $order->id
                ]
            );
        }
        //transaksi selesai

        $this->emit('notifKeranjang');

        session()->flash('message','Produk telah dimasukkan ke keranjang');  
    }

    public function tambahWishlist()
    {
        if(!Auth::user())
        {
            session()->flash('message','Anda harus login terlebih dahulu');
            return redirect()->route('login');
        }
        $is_available = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$this->product->id)->first();
        if(empty($is_available))
        {
            Wishlist::create(
            [
                'user_id'   => Auth::user()->id,
                'product_id'    => $this->product->id,
                'nama_product'  => $this->product->nama,
            ] 
            );
            $this->emit('notifWishlist');
            session()->flash('message','Produk telah dimasukkan ke wishlists');
        }
        else
        {
            session()->flash('message','Produk telah dimasukkan ke wishlist beberapa waktu yang lalu');
        }
    }
 
    public function render()
    {
        //false page
        if(!$this->product)
        {
            return view('livewire.counter')
            ->extends('layouts.app') 
            ->section('content');
        }
        return view('livewire.product-detail',
        ['product'          => $this->product,
         'result'           => $this->result,
         'nama_jasa'        => $this->nama_jasa,
         'products'         => $this->produk_terkait,
         'v_warna'          => json_decode($this->product->list_warna),
         'v_ukuran'         => json_decode($this->product->list_ukuran),
         'v_varian_lainnya' => json_decode($this->product->list_varian_lainnya)]
         )
        ->extends('layouts.app') 
        ->section('content');;
    }
}
  