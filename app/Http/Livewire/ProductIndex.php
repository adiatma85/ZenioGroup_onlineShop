<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
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
                        ->paginate(4);                     
        }
        else 
        {
            $products = Product::where('harga','>=',$harga_min)
            ->where('harga','<=',$harga_max)
            ->paginate(4);
        }
        return view('livewire.product-index',
        ['products' => $products]
        )
        ->extends('layouts.app') 
        ->section('content');

    }
}
