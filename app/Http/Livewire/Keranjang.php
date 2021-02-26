<?php

namespace App\Http\Livewire;
use DB;
use App\City;
use App\Province;
use App\Models\Order; 
use App\Models\Order_detail; 
use App\Models\Pengaturan_toko; 
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Kavist\RajaOngkir\RajaOngkir;

class Keranjang extends Component  
{

    public $order_id;
    public $order_status = 0;
    public $available_ongkir_true = 0;
    private $apiKey = "4b747e804c0428bb51f9129db3384fa8";

    public function mount()
    {
        //Autentifikasi
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
    }
    //menampilkan data keranjang yang sudah ditambahkan ongkir
    public function is_ongkir_true()
    {
        $this->order_status = 2;
    }
    //menampilkan data keranjang yang belum ditambahkan ongkir
    public function is_ongkir_false()
    {
        $this->order_status = 0;
    }

    public function destroy($id)
    {
        #PERLU DATABASE TRANSACTION
        DB::transaction(
            function() use($id) 
            { 
                //proses mengambil data order detail berdasarkan id
                $order_detail = Order_detail::find($id);
                    
                //jika tidak kosong
                if(!empty($order_detail))
                {
                    //mengambil data order yang order detail nya dihapus
                    $order      =  Order::where('user_id',Auth::user()->id)->where('status',0)->first();
                    //autentifikasi jika ada user yang akan menghapus data yang bukan miliknya
                    if($order->user_id != Auth::user()->id)
                    {
                            session()->flash('message','eits bukan hak anda');
                            return;
                    }
                    //jika jumlah order detail dari order yang akan dihapus 1, maka order juga ikut dihapus
                    $jumlah_order_detail = Order_detail::where('order_id', $order->id)->count();
                    if($jumlah_order_detail == 1) 
                    {
                        $order->delete();
                    }
                    else
                    {
                        $order->total_harga = $order->total_harga - $order_detail->jumlah_harga;
                        $order->update();
                    }        
                    //menghapus detail order
                    $order_detail->delete();
                }
            }
        );
        //transaksi selesai
        
        $this->emit('notifKeranjang'); 

        session()->flash('message', 'Pesanan Dihapus');

    }

    public function destroyAll()
    {
        #PERLU DATABASE TRANSACTION
        DB::transaction(
            function()
            {
                $order  = Order::where('user_id',Auth::user()->id)->where('status',2)->first();
                //Transaction1
                $order_details  = Order_detail::where('order_id',$order->id)->delete();
                //Transaction2
                $order->delete();
                //selesai
                $this->emit('notifKeranjang'); 
                session()->flash('message', 'Pesanan Dihapus');
            }
        );
    }
 
    public function gabungOngkir()
    {
        DB::transaction(
            function()
            { 
                //mengambil data old order
                $old_order          = Order::where('user_id',Auth::user()->id)->where('status',2)->first();
                if(!empty($old_order))
                {
                    //mengambil berat old order
                    $old_order_details  = Order_detail::where('order_id',$old_order->id)->get();
                    $total_berat_old    = 0;
                    $total_harga_old    = 0;
                    foreach ($old_order_details as $row)
                    {
                        $total_berat_old += $row->jumlah_pesanan * $row->product->berat;
                        $total_harga_old += $row->jumlah_harga;  
                    }
                    //mengambil data old_order_service
                    $old_order_service  = $old_order->jenis_service_pengiriman;
                    //mengambil data order baru
                    $new_order  = Order::where('status',0)->where('user_id',Auth::user()->id)->first();
                    //mengambil berat order yang baru
                    if(!empty($new_order)) 
                    {
                        $total_berat_new    = 0;
                        $new_order_details  = Order_detail::where('order_id',$new_order->id)->get();
                        foreach ($new_order_details as $row)
                        {
                            $total_berat_new = $row->jumlah_pesanan*$row->product->berat;
                        }
                    }
                    else
                    {
                        session()->flash('message', 'Order tidak ada');
                        return;
                    }

                    //menghitung total berat 
                    $total_berat_all    = $total_berat_new + $total_berat_old;
                    //mengambil data toko
                    $data_toko = Pengaturan_toko::where('id','!=',0)->first();
                    //mengambil biaya ongkir
                    $rajaOngkir = new RajaOngkir("4b747e804c0428bb51f9129db3384fa8");
                    $cost       = $rajaOngkir->ongkosKirim([
                        'origin'        => $data_toko->kota_id,    // ID kota/kabupaten asal di sini saya isi malang kota : 256 sebagai lokasi asal toko
                        'destination'   => Auth::user()->kota_id,      // ID kota/kabupaten tujuan
                        'weight'        => $total_berat_all,    // berat barang dalam gram
                        'courier'       => $data_toko->jasa_pengiriman    // diambil dari data toko
                    ])->get();
                    //default biaya   
                    $biaya  = -1; 
                    foreach ($cost[0]['costs'] as $row) 
                    {
                        if($row['description']  === $old_order_service)
                        {
                            $biaya  = $row['cost'][0]['value'];
                            break;
                        }
                    }
                    if($biaya != -1)
                    {      
                        foreach ($new_order_details as $row)
                        {
                            //data detail order akan diubah order_id nya menjadi order id old order
                            $order_detail           = Order_detail::where('id',$row->id)->first();
                            $order_detail->order_id = $old_order->id;
                            $order_detail->update();
                        }
                        //proses mengubah total_harga 
                        $old_order->total_harga  = $total_harga_old;
                        $old_order->total_harga += $new_order->total_harga;
                        $old_order->total_harga += $biaya;
                        $old_order->update();
                        $new_order->delete();
                        session()->flash('message', 'Ongkir telah ditambahkan');
                    }
                    else
                    {
                        session()->flash('message', 'Ongkir tidak ada');
                        //redirect ke cekOngkir dengan parameter order_id
                    }
                }
            }
        );
    }


 
    public function render() 
    { 
        $order;
        $order_details = [];
        //mengambil data order untuk prsyarat mengambil data detail order
        if(Auth::user())
        {
            $order = Order::where('user_id', Auth::user()->id)->where('status',$this->order_status)->first();
            if(!empty($order))
            {
                $order_details = Order_detail::where('order_id', $order->id)->get();
            }
            $old_order  = Order::where('user_id',Auth::user()->id)->where('status',2)->first();
            if(!empty($old_order))
            {
                $this->available_ongkir_true = 1;
            }
        }
        else
        {
            return view('livewire.counter')
            ->extends('layouts.app') 
            ->section('content'); 
        }
        

        //pemanggilan view dan pengiriman data
        return view('livewire.keranjang',[
            'order' => $order,
            'order_details' => $order_details,
            'order_status'  => $this->order_status,
            'available_ongkir_true' => $this->available_ongkir_true
        ])
        ->extends('layouts.app') 
        ->section('content');
    }
}
