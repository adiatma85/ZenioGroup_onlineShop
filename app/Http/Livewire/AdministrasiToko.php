<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaturan_toko; 
use App\Models\Product;
use App\Models\Kategori;  

class AdministrasiToko extends Component
{
    public function mount()
    {
        //autentifikasi 
        if(Auth::user())
        { 
            if(Auth::user()->id != 1)
            {
                return redirect()->to('');
            } 
        }
        else
        {
            session()->flash('message','Anda harus login terlebih dahulu');
            return redirect()->route('login');
        } 


    }
    public function render()
    {
        //false page
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

        //mengambil data pengaturan_toko
        $data_toko  = Pengaturan_toko::where('id','!=',0)->first();

        //mengambil data kategori dan produk
        $jumlah_produk      = Product::count();
        $jumlah_kategori    = Kategori::count();


        //merender
        return view('livewire.administrasi-toko',['data_toko'=> $data_toko,'jumlah_produk' => $jumlah_produk, 
        'jumlah_kategori' => $jumlah_kategori])
        ->extends('layouts.app') 
        ->section('content');
    }
}
