<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfilUser extends Component 
{

    public $stop = 0;
    public function mount()
    {
        if(!Auth::user())
        {
            return redirect()->route('login');
        }

        //melakukan pengecekkan apakah ada order yang belum tuntas(belum diproses)
        $data_order = Order::where('user_id',Auth::user()->id)->get();
        if(!empty($data_order))
        {
            foreach ($data_order as $row)
            {
                if(($row->status == 1 || $row->status == 2) && $row->is_refund == 0)
                {
                    $this->stop   = 1; 
                    break;
                }             
            }  
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
            $data_user  = User::where('id',Auth::user()->id)->first();
            return view('livewire.profil-user',[
               'data_user' => $data_user
            ])
            ->extends('layouts.app') 
            ->section('content');
        }
      
    }
}
