<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth; 
use App\Models\Pengaturan_toko;
use App\Models\Kategori;
use Livewire\Component;  
use Kavist\RajaOngkir\RajaOngkir;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
class PengaturanToko extends Component 
{
    use WithFileUploads;  
    //atribut toko
    public $jasa_pengiriman,$nama_flashsale,$kota_id,$nama_kota,$no_telepon;
    //atribut kategori
    public $nama_kategori,$gambar_kategori;
    //data provinsi 
    public $daftarProvinsi, $provinsi_id,$daftarKota;
    //key rajaongkir
    private $apiKey = "4b747e804c0428bb51f9129db3384fa8";
    public function mount()
    {
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

        //pengambilan data toko
        $data_toko = Pengaturan_toko::where('id','!=',0)->first();
        if(!empty($data_toko))
        {
            $this->kota_id          = $data_toko->kota_id;
            $this->nama_flashsale   = $data_toko->nama_flashsale;
            $this->jasa_pengiriman  = $data_toko->jasa_pengiriman;
        }    
 
        //pengambilan data kota
        $rajaOngkir             = new RajaOngkir($this->apiKey);
        $this->daftarProvinsi   = $rajaOngkir->provinsi()->all(); 

    }

    public function save_update()
    { 
        $this->validate( 
            [
                'kota_id'                  => 'required', 
                'provinsi_id'              => 'required',
                'no_telepon'               => 'required',
                'nama_flashsale'           => 'required',
                'jasa_pengiriman'          => 'required',
            ]
        );
        //mengambil nama kota berdasarkan id
        $rajaOngkir             = new RajaOngkir($this->apiKey);
        $nama_kota              = $rajaOngkir->kota()->find($this->kota_id); 
        //mengambil data toko
        $data_toko = Pengaturan_toko::where('id','!=',0)->first();
        if(!empty($data_toko))
        {
            //proses update
            $data_toko->kota_id         = $this->kota_id;
            $data_toko->provinsi_id     = $this->provinsi_id;
            $data_toko->nama_kota       = $nama_kota['city_name'];
            $data_toko->no_telepon      = $this->no_telepon;
            $data_toko->nama_flashsale  = $this->nama_flashsale;
            $data_toko->jasa_pengiriman = $this->jasa_pengiriman;
            $data_toko->update();
            session()->flash('message','Data toko berhasil diubah');
            return redirect()->to('AdministrasiToko');
        }
    }
 
    public function tambahKategori()
    {
        $this->validate( 
            [
                'nama_kategori'     => 'required', 
                'gambar_kategori'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' 
            ]
        );
        //proses memasukkan data ke file folder
        $nama_gambar = md5($this->gambar_kategori . microtime()).'.'.$this->gambar_kategori->extension();
        Storage::disk('public')->putFileAs('photos', $this->gambar_kategori,$nama_gambar);
        //proses update database
        Kategori::create(
            [
               'nama'   => $this->nama_kategori,
               'gambar' => $nama_gambar
            ]
        );
            
        session()->flash('message','Kategori berhasil ditambahkan');
        //redirect ke halaman admin
    }

    public function render()
    {
       //autentifikasi
       if(!Auth::user())
       {
           return view('livewire.counter')
           ->extends('layouts.app') 
           ->section('content');
       }
       else
       {
           if(Auth::user()->level == 0)
           {
                return view('livewire.counter')
                ->extends('layouts.app') 
                ->section('content');
           }
       }
        
       //jika autentifikasi lolos maka.....
       if($this->provinsi_id)
       {
           $rajaOngkir               = new RajaOngkir($this->apiKey);
           $this->daftarKota         = $rajaOngkir->kota()->dariProvinsi($this->provinsi_id)->get();
           //menngirim daftar kota berdasarkan provinsi yang dipilih
           return view('livewire.pengaturan-toko')
           ->extends('layouts.app') 
           ->section('content');
       }
       else
       {
           $rajaOngkir               = new RajaOngkir($this->apiKey);
           $this->daftarKota         = $rajaOngkir->kota()->dariProvinsi(-1)->get();
           //menngirim daftar kota berdasarkan provinsi yang dipilih
           return view('livewire.pengaturan-toko')
           ->extends('layouts.app') 
           ->section('content');
       }
    }
}
