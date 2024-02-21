<?php

use App\Http\Controllers\SupplierController;
use App\Http\ResponseHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return ResponseHelper::response(200, 'Bem-vindo à API desenvolvida para o teste StartGov', [
            'author' => config('app.api_author'),
            'version' => '1.0.0',
            'repository' => config('app.api_repository'),
        ]);
    });

    Route::get('/rf/cnpj/{cnpj}', function ($cnpj) {
        $response = Http::withoutVerifying()->get('https://receitaws.com.br/v1/cnpj/' . $cnpj);
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['status']) && $responseData['status'] === 'ERROR' && isset($responseData['message'])) {
                return ResponseHelper::response(400, $responseData['message']);
            } else {
                return ResponseHelper::response(200, 'Consulta realizada com sucesso', $responseData);
            }
        } else {
            return ResponseHelper::response(500, 'Erro ao realizar consulta');
        }
    });

    Route::apiResource('supplier', SupplierController::class);
});
