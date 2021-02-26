<?php

namespace App\Http\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
 
class EditAkun extends Component
{
    public $email;
    public $old_password;
    public $new_password;
    public $new_password_confirm;
    public function mount()
    {
        //autentifikasi
        if(!Auth::user())
        {
            return redirect()->route('login');
        }
    }


    public function edit()
    {
        //proses validasi
        $this->validate(
             [
                 'email'                      => 'required',   
                 'old_password'               => 'required',
                 'new_password'               => 'required',
                 'new_password_confirm'       => 'required',
             ]

         );
         
        //proses pengecekkan
        if(Hash::check($this->old_password, Auth::user()->password) && $this->new_password === $this->new_password_confirm)
        {           
            $data_user              = User::where('id',Auth::user()->id)->first();  
            $data_user->password    = Hash::make($this->new_password);
            $data_user->update();
            //update session juga
            Auth::login($data_user);
            //redirect
            session()->flash('message','Data berhasil diubah');
            return redirect()->to('ProfilUser');       
        }
        else
        {
            session()->flash('message','Password salah');
            //kasih session
        }
    }
    public function render()
    {
        $this->email    = Auth::user()->email;
        return view('livewire.edit-akun')
        ->extends('layouts.app') 
        ->section('content');  
    }
}
