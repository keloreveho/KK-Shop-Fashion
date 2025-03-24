<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\ProduitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//crée un lien qui permettra aux clients: react,vue,angular,nodejs,
//cette route permet de recupèrer la liste des produits
Route::get('/produits', [ProduitController::class, 'index']);

//cette route permet dajouter un produit
Route::post('/produits/create', [ProduitController::class, 'store']);
Route::put('/produits/edit/{id}', [ProduitController::class, 'update']);
Route::delete('/produits/delete/{produit}', [ProduitController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});