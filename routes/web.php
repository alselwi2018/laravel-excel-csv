<?php

use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class,'index']);
// Route::get('/', 'Wrencsv@importExport');
Route::post('import', [ProductController::class, 'import'])->name('import');
Route::get('export', [ProductController::class,'export'])->name('export');
