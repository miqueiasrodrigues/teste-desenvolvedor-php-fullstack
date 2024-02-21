<?php

use App\Http\ResponseHelper;
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

Route::redirect('/', '/api/'.config('app.api_version'), 302);

Route::fallback(function () {
    return ResponseHelper::response(404, 'Recurso não encontrado.');
});