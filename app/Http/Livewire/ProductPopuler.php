<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;


class ProductPopuler extends Component
{
    use WithPagination;
    public $search;
    public $min;
    public $max;
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
 
    public function render()
    {
        //membuat syarat minimal point dari semua produk
      
        $point_product  = Product::skip(10)->take(1)->orderBy('point','desc')->first();
        if($point_product)
        {
            $min_point  = $point_product->point;
        }
        else
        {
            //minimal point
            $min_point  = 0;
        }


        //mendefaultkan nilai max dan min jika tidak diisi
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

        //mengambil data products
        if($this->search)
        {
            $products = Product::where('nama','like','%'.$this->search.'%')
                        ->where('harga','>=',$harga_min)
                        ->where('harga','<=',$harga_max)
                        ->where('point','>=',$min_point)
                        ->orderBy('point','desc')
                        ->paginate(8);
        }
        else
        {
            $products = Product::where('harga','>=',$harga_min)
            ->where('harga','<=',$harga_max)
            ->where('point','>=',$min_point)
            ->orderBy('point','desc')
            ->paginate(8);
        }

        //mengirim data products ke view
        return view('livewire.product-populer',
        ['products' => $products]
        )
        ->extends('layouts.app') 
        ->section('content');

    }
}
