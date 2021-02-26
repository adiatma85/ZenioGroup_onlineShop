<?php

namespace App\Http\Livewire; 
use Livewire\Component;
use App\Models\Order;  
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
class Refund extends Component 
{ 
    public $order_id;
    //wire  
    public $bukti_refund;
    public $pesan;

    use WithFileUploads;  
    public function mount($order_id)
    {
        //mendefinisikan value dari order_id
        $this->order_id = $order_id;
        //Autentifikasi
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
        else
        {
            if(Auth::user()->level == 0)
            {
                return redirect()->to('');
            }
        }
    }

    public function save_refund() 
    {
        //proses validasi 
        $this->validate([
            'pesan'              => 'required',
            'bukti_refund'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' 
        ]);

        //proses memasukkan file
        $nama_gambar = md5($this->bukti_refund . microtime()).'.'.$this->bukti_refund->extension();
        Storage::disk('public')->putFileAs('photos', $this->bukti_refund,$nama_gambar);

        //proses edit database
        $data_order                 = Order::where('id',$this->order_id)->first();
        if(!empty($data_order))
        {
            $data_order->pesan          = $this->pesan;
            $data_order->status         = 1;
            $data_order->is_refund      = 1;
            $data_order->bukti_refund   = $nama_gambar;
            $data_order->update();
            //proses berhasil
            session()->flash('message','Pembayaran telah dikembalikan');
            return redirect()->to('DetailOrder/'.$this->order_id);
        }
        else
        {
            session()->flash('message','Order sudah tidak ada');
            return redirect()->to('DetailOrder/'.$this->order_id);
        }
      
    }

    public function render()
    {
        
        return view('livewire.refund')
        ->extends('layouts.app') 
        ->section('content');
    }
}
 