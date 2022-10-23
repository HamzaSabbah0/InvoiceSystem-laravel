<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/change-language/{locale}',[GeneralController::class,'changeLanguage'])->name('frontend_change_locale');


Route::get('invoice/print/{id}', [InvoiceController::class,'print'])->name('invoice.print');
Route::get('invoice/pdf/{id}', [InvoiceController::class,'pdf'])->name('invoice.pdf');;
Route::get('invoice/send_to_email/{id}', ['as' => 'invoice.send_to_email', 'uses' => 'InvoiceController@send_to_email']);


Route::resource('invoices',InvoiceController::class);



