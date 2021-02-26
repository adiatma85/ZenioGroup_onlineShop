<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFlashsale extends Component
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
        //memberikan nilai default dari filter harga
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
                        ->where('is_flashsale',1)
                        ->paginate(10);
                        
        }
        else
        {
            $products = Product::where('harga','>=',$harga_min)
            ->where('harga','<=',$harga_max)
            ->where('is_flashsale',1)
            ->paginate(10);
        }

        //mengirim data products ke view
        return view('livewire.product-flashsale',
        ['products' => $products]
        )
        ->extends('layouts.app') 
        ->section('content');

    }
}
