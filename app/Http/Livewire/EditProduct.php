<?php

namespace App\Http\Livewire;
use App\Models\Product; 
use App\Models\Kategori; 
use Livewire\Component; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\File; 
use Livewire\WithFileUploads;
 
class EditProduct extends Component
{
    //atribut dari produk
    public $nama, $harga, $stok, $berat, $diskon, $kategori_id, $gambar,$product_id,$tags,$deskripsi;
    public $list_warna,$list_ukuran,$list_varian_lainnya,$varian_lainnya ;
    use WithFileUploads; 
    public function mount($id)
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


        //mengambil data produk untuk ditampilkan jika produk tersebut ada
        $product  = Product::where('id',$id)->first();
        if(empty($product))
        {
            session()->flash('message','Produk tidak ada');
            return redirect()->to('Myproduct');
        } 
        else 
        {
            $this->product_id           = $product->id;
            $this->nama                 = $product->nama; 
            $this->harga                = $product->harga;
            $this->stok                 = $product->stok;
            $this->berat                = $product->berat;
            $this->diskon               = $product->diskon;
            $this->kategori_id          = $product->kategori_id;
            $this->tags                 = $product->tags;
            $this->deskripsi            = $product->deskripsi;
            $this->gambar               = $product->gambar;

            //jika varian_lainnya null, kasih kosong saja saat proses edit
            if($product->varian_lainnya != 'null')
            {
                $this->varian_lainnya       = $product->varian_lainnya;
            }
            

            $list_warna         = json_decode($product->list_warna,true);
            $list_warna_temp    = '';
            for($i = 0; $i<count($list_warna); $i++)
            {
                $list_warna_temp .=  $list_warna[$i];
                if($i != count($list_warna)-1)
                {
                    $list_warna_temp .= "#";
                }
            }
            if($list_warna_temp != 'null')
            {
                $this->list_warna = $list_warna_temp;
            }


            $list_ukuran          = json_decode($product->list_ukuran,true);
            $list_ukuran_temp     = '';
            for($i = 0; $i<count($list_ukuran); $i++)
            {
                $list_ukuran_temp  .=  $list_ukuran[$i];
                if($i != count($list_ukuran)-1)
                {
                    $list_ukuran_temp  .= "#";
                }
            }
            if( $list_ukuran_temp  != 'null')
            {
                $this->list_ukuran = $list_ukuran_temp ;
            }


            $list_varian_lainnya          = json_decode($product->list_varian_lainnya,true);
            $list_varian_lainnya_temp     = '';
            for($i = 0; $i<count($list_varian_lainnya ); $i++)
            {
                $list_varian_lainnya_temp   .=  $list_varian_lainnya [$i];
                if($i != count($list_varian_lainnya)-1)
                {
                    $list_varian_lainnya_temp   .= "#";
                }
            }
            if( $list_varian_lainnya_temp  != 'null')
            {
                $this->list_varian_lainnya =  $list_varian_lainnya_temp ;
            }

        }
    }

    public function update()
    {
        $this->validate(
            [
                'product_id'                    => 'required',
                'nama'                          => 'required',
                'harga'                         => 'required',
                'stok'                          => 'required',
                'berat'                         => 'required', 
                'diskon'                        => 'required',
                'kategori_id'                   => 'required',
                'tags'                          => 'required',
                'deskripsi'                     => 'required',
                'gambar'                        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' 
            ]
        ); 

         //proses varian product
         if(!$this->varian_lainnya)
         {
             $this->varian_lainnya   = 'null';
         }
         
         //array
         if($this->list_ukuran)
         {
             $this->list_ukuran = explode('#',$this->list_ukuran);  
             if(count($this->list_ukuran) == 0)
             {
                 $this->list_ukuran  = ['null'];
             }
         }
         else
         {
             $this->list_ukuran = ['null'];
         }



         if($this->list_warna)
         {
            $this->list_warna = explode('#',$this->list_warna);
            if(count($this->list_warna) == 0)
             {
                 $this->list_warna  = ['null'];
             }
         }
         else
         {
             $this->list_warna = ['null'];
         }
         
         
         if($this->varian_lainnya && $this->list_varian_lainnya)
         {
            $this->list_varian_lainnya = explode('#',$this->list_varian_lainnya);
            if(count($this->list_varian_lainnya) == 0)
             {
                 $this->list_varian_lainnya  = ['null'];
             }
         }
         else
         {
             $this->list_varian_lainnya = ['null'];
         }

        //proses memasukkan file gambar
        $nama_gambar = md5($this->gambar . microtime()).'.'.$this->gambar->extension();
        Storage::disk('public')->putFileAs('photos', $this->gambar,$nama_gambar);
 
        //proses memasukkan ke database
        $product = Product::where('id',$this->product_id)->first();
        if(!empty($product))
        {

            //menghapus file dari folder
            File::delete('storage/photos/'.$product->gambar);

            $product->nama          = $this->nama;
            $product->stok          = $this->stok;
            $product->berat         = $this->berat;
            $product->diskon        = $this->diskon;
            $product->gambar        = $nama_gambar;
            $product->kategori_id   = $this->kategori_id;
            $product->tags          = $this->tags;
            $product->deskripsi     = $this->deskripsi;
            $product->list_warna    = json_encode($this->list_warna,true);
            $product->list_ukuran   = json_encode($this->list_ukuran,true);
            $product->list_varian_lainnya = json_encode($this->list_varian_lainnya,true);
            $product->varian_lainnya      = $this->varian_lainnya;
            $product->update();
            session()->flash('message','Produk telah diubah');
            return redirect()->to('Myproduct');
        }
        else
        {
            session()->flash('message','Produk tidak ada');
            return redirect()->back();
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
        return view('livewire.edit-product',['kategoris'=>Kategori::all()])
        ->extends('layouts.app') 
        ->section('content');
    }
}
   