<?php

namespace App\Http\Livewire;
use App\Models\Product;
use App\Models\Order_detail;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
class Myproduct extends Component
{
    //pagination 
    use WithPagination;
    public $search;
    public function updatingSearch() 
    {
        $this->resetPage(); 
    }

    public function mount()
    {
        if(Auth::user())
        {
            if(Auth::user()->id != 1) 
            {
                return redirect()->to('');
            }
        }  
        else
        {
            return redirect()->to('login');
        }
    }

    public function destroy($id) 
    {
        $product = Product::find($id);
        if($product->delete())
        {     
            File::delete('storage/photos/'.$product->gambar);
            session()->flash('message','Produk telah dihapus');
        }

    }

    public function addToFlashsale($id)
    {
        $product = Product::find($id);
        $product->is_flashsale = 1;
        $product->update();
        session()->flash('message','Produk telah dimasukkan ke flashsale');
    }

    public function deleteFromFlashsale($id)
    {
        $product = Product::find($id);
        $product->is_flashsale = 0;
        $product->update();
        session()->flash('message','Produk telah dihapus dari flashsale');
    }
    public function render()
    {
        if($this->search)
        {
            $products = product::where('nama','like','%'.$this->search.'%')->paginate(10);
        }
        else
        {
            $products   = Product::paginate(10);
        }

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

        return view('livewire.myproduct',
        ['products'    => $products])
        ->extends('layouts.app') 
        ->section('content');
    }
}
