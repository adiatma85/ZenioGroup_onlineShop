<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;


class Mycheckout extends Component
{
    use WithPagination; 
    public function mount()
    {
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
    }

    public function destroy($order_id)
    {
        $data_order = Order::find($order_id);
        if($data_order->is_pay != 2)
        {
            $data_order->delete();
            session()->flash('message','pesanan dibatalkan...');//warning

        }
    } 


    public function render()
    {
        //mengambil data order yang status == 1
        $data_order = Order::where('status',1)->paginate(10);

        return view('livewire.mycheckout',
        [
            'orders'    => $data_order
        ])
        ->extends('layouts.app') 
        ->section('content');
    }
}
