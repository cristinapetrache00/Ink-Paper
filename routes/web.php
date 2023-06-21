<?php

use App\Http\Controllers\CarteComandaController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\UserController;
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
    return redirect('/pagina-principala');
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

Route::get('/pagina-principala', function () {
    return view('pagina-principala');
});

Route::post('/login', [UserController::class, 'login']);

Route::get('/pagina-cautare', [CarteController::class, 'paginaCautare'])->name('search');

Route::prefix('filtre')->group(function () {
    Route::get('/', [CarteController::class, 'getFilters']);
    Route::post('/', [CarteController::class, 'queryBuilder']);
});

Route::post('/search', [CarteController::class, 'search']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::prefix('favorite')->group(function () {
        Route::get('/{id}', [FavoritController::class, 'show']);
        Route::get('/', [FavoritController::class, 'index']);
        Route::post('/', [FavoritController::class, 'store']);
        Route::delete('/{id}', [FavoritController::class, 'destroy']);
    });

    Route::prefix('comenzi')->group(function () {
        Route::get('/', [ComandaController::class, 'index']);
        Route::get('/{id}', [ComandaController::class, 'show']);
        Route::put('/', [ComandaController::class, 'update']);
        Route::post('/', [ComandaController::class, 'store']);
        Route::delete('/{id}', [ComandaController::class, 'destroy']);
        Route::get('/carti/{id}', [ComandaController::class, 'carti']);
    });

    Route::prefix('reviewuri')->group(function () {
        Route::put('/', [ReviewController::class, 'update']);
        Route::post('/', [ReviewController::class, 'store']);
        Route::delete('/{id}', [ReviewController::class, 'destroy']);
    });

    Route::prefix('useri')->group(function () {
        Route::put('/parola', [CategorieController::class, 'changePassword']);
        Route::put('/', [CategorieController::class, 'update']);
    });

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

//Review
Route::get('/reviewuri', [ReviewController::class, 'index']);
Route::get('/reviewuri/{id}', [ReviewController::class, 'show']);


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


//Returnari
Route::post('/returnari', [CategorieController::class, 'store']);

//Donatii
Route::post('/donatii', [CategorieController::class, 'store']);

//Favorite


//CarteCos
Route::post('/cos', [CategorieController::class, 'store']);
Route::put('/cos', [CategorieController::class, 'put']);
Route::delete('/cos/{id}', [ReviewController::class, 'destroy']);

Route::prefix('import')->group(function () {
    Route::get('/carti', [ImportController::class, 'importCarti']);
    Route::get('/categorii', [ImportController::class, 'importCategorii']);
    Route::get('/useri', [ImportController::class, 'importUseri']);
});
