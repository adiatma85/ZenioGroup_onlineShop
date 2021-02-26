<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Kategori;
use App\Models\Product;

class KelolaKategori extends Component
{ 
    public function mount()
    {
        //autentifikasi yang bisa edit produk hanya admin
        if(Auth::user())
        { 
            if(Auth::user()->id != 1)
            {
                return redirect()->to('');
            } 
        }
        else
        {
            return redirect()->route('login');
        }
 
    }  
 
    public function destroy($id)
    {
        //mengambil data kategori yang akan dihapus
        $kategori = Kategori::where('id',$id)->first();
        //jika kategori ada
        if(!empty($kategori))
        {
            //mengambil produk yang kategorinya akan dihapus
            $data_produk    = Product::where('kategori_id',$id)->count();
            if($data_produk > 0)
            {
                session()->flash('message','Kosongkan dahulu produk pada kategori yang akan dihapus');
                return;
            }
            else
            {
                $kategori->delete();
                session()->flash('message','Kategori berhasil dihapus');

            }
        }
        else
        {
            session()->flash('message','Kategori tidak ada');
            return;
        }
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

        //mengambil data kategori
        $data_kategori  = Kategori::all();
        return view('livewire.kelola-kategori',['data_kategori' => $data_kategori])
        ->extends('layouts.app') 
        ->section('content');
    }
}
