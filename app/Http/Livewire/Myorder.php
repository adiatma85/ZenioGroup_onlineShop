<?php

namespace App\Http\Livewire;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth; 
use Livewire\WithPagination;
use Illuminate\Support\Facades\File; 
  
class Myorder extends Component
{
    use WithPagination; 
    public $is_refund = 0;

    public function mount()
    {
        if(!Auth::user())
        {
            return redirect()->route('login');
        }   
    }
   
    public function destroy($id) 
    {
        $order = Order::where('id',$id)->where('user_id',Auth::user()->id)->first(); 
        if(empty($order))
        {
            session()->flash('message','pesanan tidak ada');
            return; 
        } 

        if($order->is_refund == 1)
        {
            //menghapus data di database
            $order->delete();
            session()->flash('message','Pesanan dihapus');
            //menghapus file foto
            File::delete('storage/photos/'.$order->bukti_refund);
        }
        else
        {
            if($order->status == 4)
            {
                $order->is_delete_by_user = 1;
                $order->update();  
                session()->flash('message','Pesanan dihapus');  
            }
            else
            {
                session()->flash('message','Pesanan belum dikonfirmasi');
            }
        }
         
    }
  
    public function is_refund_true()
    {
        $this->is_refund = 1;
    }

    public function is_refund_false()
    { 
        $this->is_refund = 0;
    }
   
    public function konfirmasiTerima($order_id)
    {
        $order  = Order::find($order_id);
        if(!empty($order))
        {
            $order->status  = 4;
            $order->update();
            session()->flash('message','Pesanan telah dikonfirmasi');
        } 
    }
 
    public function render()
    { 
        if(Auth::user())
        {
            if($this->is_refund == 1)
            {
                $orders  = Order::where('user_id',Auth::user()->id)
                                ->where('is_refund',1)
                                ->where('is_delete_by_user',0)
                                ->paginate(10);
            }
            else
            {
                //menampilkan data yang status == 3 || status == -1 
                $orders  = Order::where('user_id',Auth::user()->id)
                                ->where('is_delete_by_user',0)
                                ->where('is_refund',0)
                                ->where('status','!=',1)
                                ->where('status','!=',0)
                                ->where('status','!=',2)
                                ->paginate(10);
            }
    
        }
        else
        {
            //data yang sudah pasti tidak ada karena user belum login
            $orders  = Order::where('user_id',0)->where('status','!=',-2)->where('status','!=',0)->paginate(10);
        }

      
        return view('livewire.myorder',[
            'orders'    => $orders
        ])
        ->extends('layouts.app') 
        ->section('content');
    }
}
