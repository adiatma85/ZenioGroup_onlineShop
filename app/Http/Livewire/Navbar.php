<?php

namespace App\Http\Livewire;
use DB;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\User;
use App\Models\Product;
use App\Models\Kategori;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component; 

class Navbar extends Component
{
    public $jumlah_keranjang ;
    
    public $jumlah_wishlist  ;

    protected $listeners = [
        'notifKeranjang' => 'updateKeranjang',
        'notifWishlist'  => 'updateWishlist'
    ]; 

    public function updateKeranjang()
    {
        if(Auth::user())
        {
            //default nilai keranjang
            $this->jumlah_keranjang = 0;
            //keranjang yang belum ditambah ongkir
            $order_0 = Order::where('status',0)->where('user_id', Auth::user()->id)->get();
            foreach ($order_0 as $row)
            {
               $this->jumlah_keranjang += Order_detail::where('order_id', $row->id)->count();
            }
            //keranjang yang sudah ditambah ongkir
            $order_2 = Order::where('status',2)->where('user_id', Auth::user()->id)->get(); 
            foreach ($order_2 as $row)
            {
               $this->jumlah_keranjang += Order_detail::where('order_id', $row->id)->count();
            }
        }
        else
        {
            $this->jumlah_keranjang = 0;
        }
    }

    public function updateWishlist()
    {
        if(Auth::user())
        {
            $this->jumlah_wishlist = Wishlist::where('user_id',Auth::user()->id)->count();
        }
        else
        {
            $this->jumlah_wishlist = 0;
        }
    }



    public function mount()
    {     
        if(Auth::user())
        {
            //mengambil jumlah keranjang
            if(!$this->jumlah_keranjang)
            {
                $this->jumlah_keranjang = 0;
                $order_0 = Order::where('status',0)->where('user_id', Auth::user()->id)->get();
                $order_2 = Order::where('status',2)->where('user_id', Auth::user()->id)->get(); 
                foreach ($order_0 as $row)
                {
                   $this->jumlah_keranjang += Order_detail::where('order_id', $row->id)->count();
                }
                foreach ($order_2 as $row)
                {
                   $this->jumlah_keranjang += Order_detail::where('order_id', $row->id)->count();
                }
                                       
            }
            if(!$this->jumlah_wishlist)
            {
                //mengambil jumlah wishlist
                $this->jumlah_wishlist = Wishlist::where('user_id',Auth::user()->id)->count();    
            }

        }
        else
        {
            $this->jumlah_wishlist = 0;
            $this->jumlah_keranjang = 0;
        }
       
    }

    public function render()
    {
        return view('livewire.navbar',[
            'Kategoris' => Kategori::all(),
            'jumlah_pesanan'    => $this->jumlah_keranjang, 
            'jumlah_wishlist'   => $this->jumlah_wishlist    
        ]) ->extends('layouts.app')->section('content');     
    }
}
