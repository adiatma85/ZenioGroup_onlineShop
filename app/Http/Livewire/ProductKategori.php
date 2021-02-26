<?php

namespace App\Http\Livewire;
use App\Models\Product;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class ProductKategori extends Component
{
    use WithPagination;
    public $search;
    public $min;
    public $max;
    public $nama_kategori;
    public $id_kategori;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMin()
    {
        $this->resetPage();
    }

    public function updatingMax()
    {
        $this->resetPage();
    }

    public function mount($kategoriId)
    {
        //mengambil data id_kategori
        $is_available   = Kategori::find($kategoriId);
        if($is_available)
        {
             $this->id_kategori   = $is_available->id;
             $this->nama_kategori = $is_available->nama;
        }
        else
        {
            $this->id_kategori    = 0;
            $this->nama_kategori  = 'Kategori tidak ditemukan';
        }      
    }

    

    public function render()
    {
        if(!$this->max)
        {
            $harga_max = 5000000000;
        }
        else
        {
            $harga_max = $this->max;
        }
        if(!$this->min)
        {
            $harga_min = 0;
        }
        else
        {
            $harga_min = $this->min;
        }
  
    
        //mengambil products
        if($this->search)
        {
            $products = Product::where('nama','like','%'.$this->search.'%')
                        ->where('harga','>=',$harga_min)
                        ->where('harga','<=',$harga_max)
                        ->where('kategori_id',$this->id_kategori)
                        ->paginate(10);
                        
        }
        else
        {
            $products = Product::where('harga','>=',$harga_min)
            ->where('harga','<=',$harga_max)
            ->where('kategori_id',$this->id_kategori)
            ->paginate(10);
        }
        return view('livewire.product-kategori',
        ['products' => $products, 'nama_kategori' => $this->nama_kategori]
        )
        ->extends('layouts.app') 
        ->section('content');
    }
}
