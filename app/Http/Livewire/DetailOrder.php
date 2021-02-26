<?php

namespace App\Http\Livewire;
use DB;
use App\Models\Order;
use App\Models\Order_detail; 
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DetailOrder extends Component
{
    public $order ;
    public $no_resi;
    public $data_orders_detail = [];

    public $status ;
    public $is_refund;

    public function mount($order_id)
    {
        //autentifikasi
        if(!Auth::user())
        {
            session()->flash('message','Anda harus login terlebih dahulu');
            return redirect()->route('login');
        }
        //autentifikasi
        if(Auth::user()->level!=1) 
        {  
            return redirect()->to('');
        }  

        //pengambilan data order
        $this->order              = Order::where('id',$order_id)->first();
        if(!empty($this->order))
        {
            //pengambilan data detail order
            $this->data_orders_detail = Order_detail::where('order_id',$order_id)->get();
            //jika datanya kosong akan dikembalikan
            if(empty($this->data_orders_detail))
            {
                return redirect()->to('DataOrder');
                session()->flash('message','Pesanan tidak ada');
            }
            //mendefinisikan value status
            if($this->order->status == 3)
            { 
                $this->status = 'Terkirim';
            }
            else if($this->order->status == 4)
            {
                $this->status = 'Diterima';
            }
            else if($this->order->status == 1)
            {
                $this->status = 'Terbayar';
            }
            //mengecek apakah order direffund apa tidak
            $this->is_refund    = $this->order->is_refund;
        } 
        else
        {
            return redirect()->to('DataOrder');
        }
    }
  
 
    public function konfirmasiKirim()
    { 
        //tambah no resi
        $this->validate(
            [
                'no_resi'    => 'required'
            ] 
        ); 

        $this->order->no_resi = $this->no_resi;
        $this->order->status  =  3;
        $this->order->update();

        session()->flash('message','Pesanan telah dikirim');
        return redirect()->to('DataOrder');
    }  

    public function konfirmasiBatal($id)
    { 
        $order = Order::where('id',$id)->first();
        $order->status =  1;
        $order->update();

        session()->flash('message','Pesanan batal terkirim');
        return redirect()->to('DataOrder');
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
        else
        {
            if(Auth::user()->level!=1)
            { 
                return view('livewire.counter')
                ->extends('layouts.app') 
                ->section('content');
            } 
        }
        return view('livewire.detail-order',[
            'order' => $this->order,'order_details' => $this->data_orders_detail,'status'   => $this->status
        ])
        ->extends('layouts.app') 
        ->section('content');
    }
}
