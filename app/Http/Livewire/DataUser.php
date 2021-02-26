<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 
use Livewire\Component;
use Kavist\RajaOngkir\RajaOngkir;
 
class DataUser extends Component
{ 
    public $alamat,$alamat_lengkap,$no_telpon,$provinsi_id,$kota_id,$no_rekening,$nama_bank;
    public $stop = 0;
    public $daftarProvinsi;
    public $daftarKota;
    private $apiKey = "4b747e804c0428bb51f9129db3384fa8";
    public function mount()
    { 
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
        //melakukan pengecekkan apakah ada order yang belum tuntas(belum diproses)
        $data_order = Order::where('user_id',Auth::user()->id)->get();
        if(!empty($data_order))
        {
            foreach ($data_order as $row)
            {
                if(($row->status == 1 || $row->status == 2) && $row->is_refund == 0)
                {
                    $this->stop   = 1; 
                    break;
                }             
            }  
        }
        //jika ada yang belum selesai maka akan dikembalikan
        if($this->stop == 1)
        {   
            session()->flash('message','Data tidak bisa berubah, ada order yang belum diproses');
            return redirect()->to('ProfilUser');
        }

        //mengambil data provinsi 
        $rajaOngkir             = new RajaOngkir($this->apiKey);
        $this->daftarProvinsi   = $rajaOngkir->provinsi()->all();
        //menngambil data user
        $data_user = User::where('id',Auth::user()->id)->first();
        if(!empty($data_user))
        {
            $this->alamat         = $data_user->alamat;
            $this->alamat_lengkap = $data_user->alamat_lengkap;
            $this->no_telpon      = $data_user->no_telpon;
            $this->no_rekening    = $data_user->no_rekening;  
            $this->nama_bank      = $data_user->nama_bank; 
            $this->provinsi_id    = $data_user->provinsi_id;
            $this->kota_id        = $data_user->kota_id;
        }    

    }

    public function store()
    {
        //mengambil nama kota
        if($this->kota_id)
        {
            $rajaOngkir             = new RajaOngkir($this->apiKey);
            $nama_kota              = $rajaOngkir->kota()->find($this->kota_id);
            $this->alamat           = $nama_kota['city_name'];
        }
        //validasi
         $this->validate(
             [
                 'alamat'            => 'required',   
                 'alamat_lengkap'    => 'required',
                 'no_telpon'         => 'required',
                 'no_rekening'       => 'required',
                 'nama_bank'         => 'required',
                 'provinsi_id'       => 'required',
                 'kota_id'           => 'required',
             ]
         ); 
        //melakukan proses update data
         if(Auth::user())
         {
            //menyiapkan data 
            $data_user                  = User::where('id',Auth::user()->id)->first();
            $data_user->alamat          = $this->alamat; 
            $data_user->alamat_lengkap  = $this->alamat_lengkap;
            $data_user->no_telpon       = $this->no_telpon;
            $data_user->no_rekening     = $this->no_rekening; 
            $data_user->nama_bank       = $this->nama_bank;
            $data_user->provinsi_id     = $this->provinsi_id;
            $data_user->kota_id         = $this->kota_id;
            $data_user->lengkap         = 1;
            $data_user->update();
              
            //proses update session
            Auth::login($data_user);
            //dikembalikan ke user profil
            session()->flash('message','Data berhasil diubah');
            return redirect()->to('ProfilUser');
          }
    }
 
    public function render()
    {
        //autentifikasi
        if(!Auth::user() || $this->stop == 1)
        {
            return view('livewire.counter')
            ->extends('layouts.app') 
            ->section('content');
        }
         
        //jika autentifikasi lolos maka.....
        if($this->provinsi_id)
        {
            $rajaOngkir               = new RajaOngkir($this->apiKey);
            $this->daftarKota         = $rajaOngkir->kota()->dariProvinsi($this->provinsi_id)->get();
            //menngirim daftar kota berdasarkan provinsi yang dipilih
            return view('livewire.data-user', ['daftarKota' => $this->daftarKota] )
            ->extends('layouts.app') 
            ->section('content');
        }
        else
        {
            $rajaOngkir               = new RajaOngkir($this->apiKey);
            $this->daftarKota         = $rajaOngkir->kota()->dariProvinsi(-1)->get();
            //menngirim daftar kota berdasarkan provinsi yang dipilih
            return view('livewire.data-user', ['daftarKota' => $this->daftarKota] )
            ->extends('layouts.app') 
            ->section('content');
        }

    
    }
}
  