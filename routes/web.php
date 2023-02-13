<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountInfoController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('account-infos', AccountInfoController::class);

Route::post('account-infos.batchDelete', [AccountInfoController::class, 'batchDelete'])->name('account-infos.batchDelete');
Route::post('account-infos.export', [AccountInfoController::class, 'export'])->name('account-infos.export');
