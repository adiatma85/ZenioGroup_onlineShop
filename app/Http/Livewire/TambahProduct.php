<?php

namespace App\Http\Livewire;
use App\Models\Product;
use App\Models\Kategori;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
  
class TambahProduct extends Component
{
    public $nama, $harga, $stok, $berat, $diskon, $kategori_id, $gambar,$tags,$deskripsi,$varian_lainnya; 
    public $list_ukuran,$list_nama,$list_varian_lainnya,$list_warna;
    use WithFileUploads; 
    public function mount()
    {
        if(Auth::user())
        {
            if(Auth::user()->id != 1)
            {
                return redirect()->back();
            }
        } 
        else 
        {
            return redirect()->route('login');
        }
     
    }
  
    public function store()
    {
        //proses validasi atau syarat agar data bisa dimasukkan
        $this->validate( 
            [
                'nama'                  => 'required',
                'harga'                 => 'required',
                'stok'                  => 'required',
                'berat'                 => 'required', 
                'diskon'                => 'required',
                'kategori_id'           => 'required',
                'tags'                  => 'required',
                'deskripsi'             => 'required',
                'gambar'                => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' 
            ]
        );  

        //proses varian product
        if(!$this->varian_lainnya)
        {
            $this->varian_lainnya   = 'null';
        }
        
        //array
        if($this->list_ukuran)
        {
            $this->list_ukuran = explode('#',$this->list_ukuran);  
            if(count($this->list_ukuran) == 0)
            {
                $this->list_ukuran  = ['null'];
            }
        }
        else
        {
            $this->list_ukuran = ['null'];
        }
        if($this->list_warna)
        {
           $this->list_warna = explode('#',$this->list_warna);
           if(count($this->list_warna) == 0)
            {
                $this->list_warna  = ['null'];
            }
        }
        else
        {
            $this->list_warna = ['null'];
        }      
        if($this->varian_lainnya && $this->list_varian_lainnya)
        {
           $this->list_varian_lainnya = explode('#',$this->list_varian_lainnya);
           if(count($this->list_varian_lainnya) == 0)
            {
                $this->list_varian_lainnya  = ['null'];
            }
        }
        else
        {
            $this->list_varian_lainnya = ['null'];
        }
        
        
        //proses memasukkan file gambar
        $nama_gambar = md5($this->gambar . microtime()).'.'.$this->gambar->extension();
        Storage::disk('public')->putFileAs('photos', $this->gambar,$nama_gambar);

        //proses memasukkan ke database
        Product::create(
            [
                'nama'                  => $this->nama,
                'harga'                 => $this->harga, 
                'stok'                  => $this->stok,
                'berat'                 => $this->berat,
                'is_flashsale'          => 0,
                'diskon'                => $this->diskon,
                'kategori_id'           => $this->kategori_id, 
                'tags'                  => $this->tags,
                'deskripsi'             => $this->deskripsi,
                'list_ukuran'           => json_encode($this->list_ukuran,true),
                'list_warna'            => json_encode($this->list_warna,true),
                'varian_lainnya'        => $this->varian_lainnya,
                'list_varian_lainnya'   => json_encode( $this->list_varian_lainnya,true),
                'gambar'                => $nama_gambar
            ]
        );
        session()->flash('message','Produk telah dimasukkan');
        return redirect()->to('Myproduct');
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
        $kategoris = Kategori::all();

        return view('livewire.tambah-product',
        ['kategoris'  => $kategoris])
        ->extends('layouts.app') 
        ->section('content');
    }
}
  