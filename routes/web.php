<?php

use App\Http\Controllers\CarteComandaController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ImportController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pagina-principala', function () {
    return view('pagina-principala');
});

Route::get('/pagina-inregistrare', function () {
    return view('pagina-inregistrare');
});

Route::get('/pagina-autentificare', function () {
    return view('pagina-autentificare');
})->name('login');

Route::get('/pagina-donare', function () {
    return view('pagina-donare');
});


Route::group(['middleware' => 'auth'], function () {

});

//Client
Route::get('/clienti', [ClientController::class, 'index']);
Route::get('/clienti/{id}', [ClientController::class, 'show']);
Route::put('/clienti', [ClientController::class, 'update']);
Route::post('/clienti', [ClientController::class, 'store']);
Route::delete('/clienti/{id}', [ClientController::class, 'destroy']);
Route::get('/clienti/user', [ClientController::class, 'userData']);
Route::get('/clienti/comenzi', [ClientController::class, 'comenzi']);
Route::get('/clienti/favorite', [ClientController::class, 'favorite']);
Route::get('/clienti/cos', [ClientController::class, 'userData']);

Route::get('/client-autentificat', [ClientController::class, 'getUserData']);

//Comanda
Route::get('/comenzi', [ComandaController::class, 'index']);
Route::get('/comenzi/{id}', [ComandaController::class, 'show']);
Route::put('/comenzi', [ComandaController::class, 'update']);
Route::post('/comenzi', [ComandaController::class, 'store']);
Route::delete('/comenzi/{id}', [ComandaController::class, 'destroy']);
Route::get('/comenzi/carti/{id}', [ComandaController::class, 'carti']);

//Review
Route::get('/reviewuri', [ReviewController::class, 'index']);
Route::get('/reviewuri/{id}', [ReviewController::class, 'show']);
Route::put('/reviewuri', [ReviewController::class, 'update']);
Route::post('/reviewuri', [ReviewController::class, 'store']);
Route::delete('/reviewuri/{id}', [ReviewController::class, 'destroy']);

//Carte
Route::get('/carti', [CarteController::class, 'index']);
Route::get('/carti/{id}', [CarteController::class, 'show']);
Route::put('/carti', [CarteController::class, 'update']);
Route::post('/carti', [CarteController::class, 'store']);
Route::delete('/carti/{id}', [CarteController::class, 'destroy']);
Route::get('/carti/categorii/{id}', [CarteController::class, 'categorii']);
Route::get('/carti/reviewuri/{id}', [CarteController::class, 'reviewuri']);

//CarteComanda
Route::get('/carti-comanda', [CarteComandaController::class, 'index']);
Route::get('/carti-comanda/{id}', [CarteComandaController::class, 'show']);
Route::put('/carti-comanda', [CarteComandaController::class, 'update']);
Route::post('/carti-comanda', [CarteComandaController::class, 'store']);
Route::delete('/carti-comanda/{id}', [CarteComandaController::class, 'destroy']);

//Categorie
Route::get('/categorii', [CategorieController::class, 'index']);
Route::get('/categorii/{id}', [CategorieController::class, 'show']);
Route::put('/categorii', [CategorieController::class, 'update']);
Route::post('/categorii', [CategorieController::class, 'store']);
Route::delete('/categorii/{id}', [CategorieController::class, 'destroy']);
Route::get('/categorie/carti/{id}', [CategorieController::class, 'carti']);

//User
Route::post('/user', [CategorieController::class, 'store']);
Route::put('/user/parola', [CategorieController::class, 'changePassword']);
Route::put('/user', [CategorieController::class, 'update']);

//Returnari
Route::post('/returnari', [CategorieController::class, 'store']);

//Donatii
Route::post('/donatii', [CategorieController::class, 'store']);

//Favorite
Route::post('/favorite', [CategorieController::class, 'store']);
Route::delete('/favorit/{id}', [ReviewController::class, 'destroy']);

//CarteCos
Route::post('/cos', [CategorieController::class, 'store']);
Route::put('/cos', [CategorieController::class, 'put']);
Route::delete('/cos/{id}', [ReviewController::class, 'destroy']);

Route::prefix('import')->group(function () {
    Route::get('/carti', [ImportController::class, 'importCarti']);
    Route::get('/categorii', [ImportController::class, 'importCategorii']);
    Route::get('/useri', [ImportController::class, 'importUseri']);
});
