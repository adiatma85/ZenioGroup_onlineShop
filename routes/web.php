<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Keranjang;

 
/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for  your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
 
Auth::routes();
Route::get('/', \App\Http\Livewire\Home::class);
Route::get('/ProductIndex', \App\Http\Livewire\ProductIndex::class);
Route::get('/ProductWishlist', \App\Http\Livewire\ProductWishlist::class);
Route::get('/ProductPopuler', \App\Http\Livewire\ProductPopuler::class);
Route::get('/ProductFlashsale', \App\Http\Livewire\ProductFlashsale::class);
Route::get('/ProductKategori/{kategoriId}', \App\Http\Livewire\ProductKategori::class);
Route::get('/ProductDetail/{id}', \App\Http\Livewire\ProductDetail::class);
Route::get('/Keranjang', \App\Http\Livewire\Keranjang::class)->name('keranjang');
Route::get('/Checkout', \App\Http\Livewire\Checkout::class);
Route::get('/DataOrder', \App\Http\Livewire\DataOrder::class);
Route::get('/DetailOrder/{order_id}', \App\Http\Livewire\DetailOrder::class);
Route::get('/Navbar', \App\Http\Livewire\Navbar::class);
Route::get('/Myorder', \App\Http\Livewire\Myorder::class);
Route::get('/Myproduct', \App\Http\Livewire\Myproduct::class);
Route::get('/TambahProduct', \App\Http\Livewire\TambahProduct::class);
Route::get('/EditProduct/{id}', \App\Http\Livewire\EditProduct::class);
Route::get('/CekOngkir/{order_id}', \App\Http\Livewire\CekOngkir::class);
Route::get('/DataUser', \App\Http\Livewire\DataUser::class);
Route::get('/ProfilUser', \App\Http\Livewire\ProfilUser::class);
Route::get('/EditAkun', \App\Http\Livewire\EditAkun::class);
Route::get('/Refund/{order_id}', \App\Http\Livewire\Refund::class);
Route::get('/Payment/{order_id}', \App\Http\Livewire\Payment::class);
Route::get('/PengaturanToko', \App\Http\Livewire\PengaturanToko::class);
Route::get('/AdministrasiToko', \App\Http\Livewire\AdministrasiToko::class);
Route::get('/KelolaKategori', \App\Http\Livewire\KelolaKategori::class);
Route::get('/Mycheckout', \App\Http\Livewire\Mycheckout::class);
