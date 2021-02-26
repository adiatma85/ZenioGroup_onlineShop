<?php

namespace App\Http\Livewire;
use DB;
use App\Models\Wishlist;
use Livewire\Component; 
use Livewire\WithPagination; 
use Illuminate\Support\Facades\Auth;

class ProductWishlist extends Component
{
    use WithPagination;
    public $search;
    public function updatingSearch()  
    {
        $this->resetPage();
    }

    public function mount()
    { 
        
        if(!Auth::user())
        {
            return redirect()->to('login');
        }
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);
        $wishlist->delete();
        session()->flash('message','Produk telah dihapus dari daftar keinginan');
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
            if($this->search)
            {
                $wishlists = Wishlist::where('nama_product','like','%'.$this->search.'%')
                        ->where('user_id',Auth::user()->id)
                        ->paginate(10);
            }
            else
            {
                $wishlists = Wishlist::where('user_id',Auth::user()->id)
                ->paginate(10);
            }
            return view('livewire.product-wishlist',
            ['products' => $wishlists]
            )
            ->extends('layouts.app') 
            ->section('content');
        }
      
    }
}


