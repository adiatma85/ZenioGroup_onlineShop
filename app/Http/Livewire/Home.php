<?php

namespace App\Http\Livewire; 
use DB;
use App\Models\Product;
use App\Models\Kategori;
use App\Models\Tags_point;
use App\Models\User;
use App\Models\User_activity;
use App\Models\Pengaturan_toko;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component   
{
    
    public function render()
    {
       

        #memproses produk populer(mingguan, jadi setiap minggu akan di 0 kan)
        if(Pengaturan_toko::where('id','!=',0)->first()->product_populer_update_at > date('Y-m-d'))
        {
            Product::where('id','!=',0)->update(['point' => 0]);
        }

        #memproses rekomendasi produk
        $product_rekomendasi = [];
        if(Auth::user())
        {
            //proses memperbarui user_activity
            $user_activity  = User_activity::where('user_id',Auth::user()->id)->first();
            if(!empty($user_activity))
            {
                if($user_activity->activity_day != date('D', strtotime(date('Y-m-d'))))
                {
                    $user_activity->activity_day    = date('D', strtotime(date('Y-m-d')));
                    $user_activity->is_active       = 0;
                    $user_activity->activity_point  = 0;
                    $user_activity->update();
                    //mengubah semua nilai pada tags_point_temp menjadi 0
                    Tags_point::where('user_id',Auth::user()->id)->where('tags_point_temp','!=',0)->update(['tags_point_temp' => 0]);
                }
            } 
            else
            { 
                User_activity::create(
                    [
                        'user_id'           => Auth::user()->id,
                        'activity_point'    => 0,
                        'is_active'         => 0,
                        'activity_day'      => date('D', strtotime(date('Y-m-d'))),   
                    ]
                );
            }


            //memproses produk yang direkomendasikan
            $highest_tags_point = Tags_point::where('user_id',Auth::user()->id)->skip(0)->take(10)
                                            ->orderBy('tags_point','desc')->get(); 
            $indeks  = 0;
            foreach ($highest_tags_point as $row)
            {
                $tags[$indeks]   = $row->tags;
                $indeks++; 
            }
            $break_loop = false;
            $tags1      = '';
            $tags2      = '';
            for($i=0; $i<$indeks; $i++)
            {
                for($j=$i+1; $j<$indeks; $j++)
                {
                    $is_available_product   = Product::where('tags','like','%'.$tags[$i].'%')
                                                     ->where('tags','like','%'.$tags[$j].'%')
                                                     ->count();
                    if($is_available_product >= 1)
                    {
                        $tags1      = $tags[$i];
                        $tags2      = $tags[$j];
                        $break_loop = true;
                        break;
                    } 
                }
                if($break_loop)
                {
                    break;
                }
            }
            if($break_loop)
            {
                $product_rekomendasi    =  Product::where('tags','like','%'.$tags1.'%')
                ->where('tags','like','%'.$tags2.'%')
                ->get();
            }
        } 
        

        $kategori_populer   = Kategori::skip(0)->take(4)->orderBy('point','desc')->get();
        //dd($kategori_populer);
        $product_flashsale  = Product::where('is_flashsale',1)->skip(0)->take(8)->orderBy('point','desc')->get();
        $product_populer    = Product::skip(0)->take(4)->orderBy('point','desc')->get();
        $product_semua      = Product::skip(0)->take(8)->orderBy('id','asc')->get();
      
        return view('livewire.home',
        [
            'kategori_populer'      => $kategori_populer,
            'product_flashsale'     => $product_flashsale,
            'product_populer'       => $product_populer,
            'product_semua'         => $product_semua,
            'product_rekomendasi'   => $product_rekomendasi,
            'nama_flashsale'        => Pengaturan_toko::where('id','!=',0)->first()->nama_flashsale,
        ])
        ->extends('layouts.app')->section('content');     
    }
}
