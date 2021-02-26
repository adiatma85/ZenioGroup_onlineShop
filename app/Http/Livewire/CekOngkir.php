<?php
namespace App\Http\Livewire;
use App\City;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Pengaturan_toko; 
use Livewire\Component; 
use Kavist\RajaOngkir\RajaOngkir;

class CekOngkir extends Component
{
    //parameter data order yang dipakai
    public $order_id;
    //result jasa ongkir
    public $result = [];
    public $nama_jasa ;
    private $apiKey = "4b747e804c0428bb51f9129db3384fa8";
    //data dan alamat user
    public $no_telpon,$alamat,$alamat_lengkap;
   
    public function mount($order_id)
    { 
        //Autentifikasi
        if(!Auth::user())
        {
            return redirect()->route('login');
        }

        //jika user belum melengkapi data, maka tidak bisa menambahkan ongkir
        if(Auth::user()->lengkap == 0)
        {
            session()->flash('message','silakan lengkapi alamat anda terlebih dahulu');
            return redirect()->to('ProfilUser');
        }


        //mengambil data dan alamat user
        $this->no_telpon        = Auth::user()->no_telpon;
        $this->alamat           = Auth::user()->alamat;
        $this->alamat_lengkap   = Auth::user()->alamat_lengkap;


        //sebagai parameter untuk mengambil data order di fungsi tambahBiayaPengiriman
        $this->order_id   = $order_id;
        $data_order = Order::where('id',$order_id)->first();
        if(!empty($data_order))
        {
            //Autentifikasi apakah order tersebut benar benar milik si user
            if($data_order->user_id != Auth::user()->id)
            {
                return redirect()->to('');
            }

            //mengambil data berat
            $total_berat    = 0;
            $order_details  = Order_detail::where('order_id',$order_id)->get();
            foreach ($order_details as $row)
            {
                $total_berat += $row->jumlah_pesanan*$row->product->berat;
            }

 
            //mengambil data toko
            $data_toko = Pengaturan_toko::where('id','!=',0)->first();

            //mengambil data biaya ongkos kirim
            $rajaOngkir = new RajaOngkir($this->apiKey);
            $cost       = $rajaOngkir->ongkosKirim([
                'origin'        => $data_toko->kota_id,     // ID kota/kabupaten asal di sini saya isi malang kota : 256 sebagai lokasi asal toko
                'destination'   => Auth::user()->kota_id,      // ID kota/kabupaten tujuan
                'weight'        => $total_berat,    // berat barang dalam gram
                'courier'       => $data_toko->jasa_pengiriman    // diambil dari data toko
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
            session()->flash('message','Order tidak ada');
            return redirect()->to('Keranjang');
        }
    }

    public function tambahBiayaPengiriman($indeks)
    {
        //mencari harga ongkos kirim dan jenis service nya yang telah dipilih
        $biayaPengiriman    = 0;//definisikan biaya terlebih dahulu
        $i                  = 0;
        $description        = "belum dipilih";
        foreach ($this->result as $row)
        {
            if($indeks == $i)
            {
                $biayaPengiriman    = $row['biaya']; 
                $description        = $row['description'];
                break;
            }
            $i++;   
        }
        
        $order = Order::where('id',$this->order_id)->first();
        if(!empty($order))
        {
            //mengambil total harga untuk order
            $order_details  = Order_detail::where('order_id',$order->id)->get();
            $total_harga    = 0;
            foreach ($order_details as $row)
            {
                $total_harga    += $row->jumlah_harga;
            }


            //mengupdate data order
            $order->total_harga              = $total_harga + $biayaPengiriman;
            $order->jenis_service_pengiriman = $description;
            $order->status                   = 2;
            $order->update();
            session()->flash('message','Ongkos kirim berhasil ditambahkan');             
        }
        else
        {
            session()->flash('message','Order sudah tidak ada');
        }

        //di redirect ke halaman keranjang
        return redirect()->to('Keranjang');
    }

    public function render()
    {  
        return view('livewire.cek-ongkir',
        [
            'nama_jasa'         => $this->nama_jasa,
            'result'            => $this->result,
            'order_id'          => $this->order_id,
        ])
        ->extends('layouts.app') 
        ->section('content');
    }

}