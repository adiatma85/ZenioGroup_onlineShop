<?php

namespace App\Http\Livewire;
use DB;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\User;
use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component     
{
    //data user
    public $nohp, $alamat, $alamat_lengkap;
    public $catatan;
    //data order user
    public $total_harga;
    
    public function mount()
    {
        //jika belum login dikembalikan
        if(!Auth::user())
        {
            session()->flash('message','Anda harus login terlebih dahulu');
            return redirect()->route('login'); 
        }

        //default no hp dan alamat, informasi yang akan ditampilkan dihalaman checkout
        $this->nohp             = Auth::user()->no_telpon;
        $this->alamat_lengkap   = Auth::user()->alamat_lengkap;
        $this->alamat           = Auth::user()->alamat;

        //mengambil data order yang akan dicheckout berdasarkan user id
        $order          = Order::where('user_id', Auth::user()->id)->where('status', 2)->first();

        //jika ada pesanan, kasih harga yang harus dicheckout
        if(!empty($order))
        {
            $this->total_harga          = $order->total_harga;
        }
        else
        { 
            session()->flash('message','Order sudah tidak ada');
            return redirect()->route('keranjang');
        }

    } 
     
    public function checkout() 
    {
        $this->validate(
            [
                'catatan'   => 'required',
            ]
        );
        //memasukkan data ke order
        $order       = Order::where('user_id', Auth::user()->id)->where('status', 2)->first();
        $order->catatan = $this->catatan;
        $order->update();

        //transaction 
        DB::transaction(function() 
        {
            $order       = Order::where('user_id', Auth::user()->id)->where('status', 2)->first();
            if(!empty($order))
            {
                //updating status order(Transaksi 1)
                $order->status          = 1;
                $order->update();

                //mengambil semua data order_details 
                $detail_orders          = Order_detail::where('order_id',$order->id)->get();

                //memberikan point ke product yang dicheckout(Transaksi 2)
                DB::raw('LOCK TABLES products WRITE');
                foreach ($detail_orders as $row)
                {
                    $product    = Product::where('id',$row->product->id)->first();
                    $product->point += 1;
                    $product->update();
                }
                DB::raw('UNLOCK TABLES');

                //memberikan point ke kategori yang dicheckout(Transaksi 3)
                DB::raw('LOCK TABLES kategoris WRITE');
                foreach ($detail_orders as $row)
                {
                    $kategori    = Kategori::where('id',$row->product->kategori_id)->first();
                    $kategori->point += 1;
                    $kategori->update();
                }
                DB::raw('UNLOCK TABLES');
                //update notifikasi keranjang
                $this->emit('notifKeranjang');
                //redirect ke payment
                return redirect()->to('Payment/'.$order->id);
            }
            else
            {
                session()->flash('message','Order sudah tidak ada');
                return redirect()->route('keranjang');
            }
        });
    
    }
 
    public function render()
    {
        //false page
        if(!Auth::user())
        {
            return view('livewire.counter')
            ->extends('layouts.app') 
            ->section('content');
        }
        return view('livewire.checkout' )
        ->extends('layouts.app') 
        ->section('content');
    }
}
