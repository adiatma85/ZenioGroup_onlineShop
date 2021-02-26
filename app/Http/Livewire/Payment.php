<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

 
 
class Payment extends Component
{
    public $snapToken; 
    public $is_pay = 0;
    //atribut status pay
    public $va_number,$gross_amount,$bank,$transaction_status,$deadline;
    //atribut order
    public $order_id;

    public function mount($order_id) 
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-KRwE8hKa9KqpliDwX9ujecLY';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //jika belum login 
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
 
        //pengecekkan apakah user melakukan paying(second case)
        if(isset($_GET['result_data']))
        {
            //update data order di mana is_pay menjadi 1;
            $current_status     = json_decode($_GET['result_data'],true);
            $order_id           = $current_status['order_id'];
            $data_order         = Order::where('id',$order_id)->where('status',1)->where('is_refund',0)->first();
            $data_order->is_pay = 1;
            $data_order->update();
        }
        
        else 
        {
            //mengambil data order
            $data_order = Order::where('id',$order_id)->where('status',1)->where('is_refund',0)->first();
            if(empty($data_order))
            {
                //hanya akan menampilkan session
                $this->is_pay   = -1;
                session()->flash('message','Order tidak ada');//warning
                return;     
            }
        }       

        //pengecekkan apakah is_pay pada database order 1 atau 2, jika salah satu di antara itu, maka pasti sudah masuk di midtran  
        if($data_order->is_pay > 0)
        { 
            $this->is_pay   = 1; 
            $status = \Midtrans\Transaction::status($order_id);
            $status = json_decode(json_encode($status),true);
            //dd($status);
            $this->va_number            = $status['va_numbers'][0]['va_number'];
            $this->gross_amount         = $status['gross_amount'];
            $this->bank                 = $status['va_numbers'][0]['bank'];
            $this->transaction_status   = $status['transaction_status'];
            $transaction_time           = $status['transaction_time'];
            $this->deadline             = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
            
            //pengecekkan status transaksi
            if($this->transaction_status === 'expire')
            {
                //kasih informasi
                session()->flash('message','Transaksi telah kadaluarsa.. silakan order lagi');//danger
                //is_pay ditampilkan agar user bisa melakukan paying
                $this->is_pay       = -1;
                //menghapus data order 
                $data_order->delete();     
            } 
            else if($this->transaction_status === 'settlement')
            {
                $data_order->is_pay = 2;
                $data_order->update();
                session()->flash('message','Pembayaran anda berhasil.. silakan klik Konfirmasi Pembayayan');//success
                $this->transaction_status   = 'Pembayaran berhasil dilakukan';
            }
            else if($this->transaction_status === 'pending')
            {
                session()->flash('message','silakan bayar berdasarkan nomor virtual di bawah ini');//warning
                $this->transaction_status   = 'Menunggu Anda melakukan pembayaran';
            }    
        } 
        else 
        {
            session()->flash('message','silakan pilih metode pembayaran dengan menekan tombol di bawah ini');//warning
            $params = array(
                'transaction_details' => array(
                    'order_id' => $data_order->id,
                    'gross_amount' => $data_order->total_harga,
                ),
                'customer_details' => array(
                    'first_name' => 'Saudara....',
                    'last_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->no_telpon,
                ),
            );
            //mengambil data token
            $this->snapToken = \Midtrans\Snap::getSnapToken($params);    
        }
        

        //note 
        //is_pay == 1, tampilkan status, is_pay == 0 tampilkan pay, is_pay == -1, hanya session
        //default : halaman checkout
    }
    //formalitas
    public function konfirmasiPembayaran($order_id)
    {

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-KRwE8hKa9KqpliDwX9ujecLY';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //mengambil data di session
        $status = \Midtrans\Transaction::status($order_id);
        $status = json_decode(json_encode($status),true);

        //jika status transaksi dari order_id telah terbayar maka ubah status di database order
        if($status['transaction_status'] === 'settlement')
        {
            $data_order = Order::where('id',$order_id)->first();
            $data_order->is_pay = 2;
            $data_order->update();
            session()->flash('message','Transaksi anda telah sukses...');//success
        }
        else
        {
            session()->flash('message','silakan lakukan pembayaran terlebih dahulu');//warning
        }
      
    } 

    
 
    public function render()
    {
        return view('livewire.payment',[
            'token'   => $this->snapToken
        ])
        ->extends('layouts.app') 
        ->section('content');
    }

}
