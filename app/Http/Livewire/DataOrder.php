<?php

namespace App\Http\Livewire;
use DB;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 
use Livewire\Component;
use Livewire\WithPagination;

class DataOrder extends Component
{ 
    //untuk pagination
    use WithPagination; 
    public function mount() 
    {
        //AUTENTIFIKASI
        if(!Auth::user())
        {
            return redirect()->route('login');  
        }
        //jika bukan admin, maka tidak ada hak melihat data order
        else
        {
            if(Auth::user()->level != 1)
            { 
                return redirect()->to('');
            } 
        }      
    } 
  
    public function destroy($id)  
    {
        $order = Order::where('id',$id)->first(); 
        if(!empty($order))
        {
            if($order->is_refund == 1 || $order->status == 4)
            {
                $order->is_delete_by_admin  = 1; 
                $order->update();
                session()->flash('message','pesananan berhasil dihapus');
                return;
            }
            else
            {
                session()->flash('message','pesananan gagal dihapus, karena belum diproses');
            }       
        }
        else
        {
            session()->flash('message','pesananan tidak ada');
        }
    }

    public function render() 
    {
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
        //hanya akan menampilkan order yang is_pay == 2 yang jika is_refund == 1, maka => pesanan dibatalkan
        //status == 3 =>  pesanan dikirim dan default => pesanan telah dibayar
        $orders = Order::where('is_pay','=',2)->where('is_delete_by_admin',0)->paginate(20); 

        return view('livewire.data-order',[
            'orders' => $orders
        ])
        ->extends('layouts.app') 
        ->section('content');
    }
}
