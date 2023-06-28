<?php

use App\Http\Controllers\CarteComandaController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CarteCosController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ComandaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DonatieController;
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
    return redirect('/principala');
});
Route::get('/inregistrare', function () {
    return view('pagina-inregistrare');
});
Route::get('/autentificare', function () {
    return view('pagina-autentificare');
});
Route::get('/donare', function () {
    return view('pagina-donare');
});
Route::get('/principala', function () {
    return view('pagina-principala');
});
Route::get('/profil', function () {
    return view('pagina-profil');
});
Route::get('/cart', function () {
    return view('pagina-cos');
});

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
    });

    Route::prefix('reviewuri')->group(function () {
        Route::put('/', [ReviewController::class, 'update']);
        Route::post('/', [ReviewController::class, 'store']);
        Route::delete('/{id}', [ReviewController::class, 'destroy']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'show']);
        Route::put('/parola', [UserController::class, 'changePassword']);
        Route::put('/', [UserController::class, 'update']);
        Route::post('/logout', [UserController::class, 'logout']);
    });

    Route::get('/comenzi-carti', [ComandaController::class, 'carti']);
    Route::post('/retur', [CarteComandaController::class, 'returnOrder']);
    Route::get('/comanda-carti/{id_comanda}', [ComandaController::class, 'cartiComanda']);
});

Route::post('/donatie', [DonatieController::class, 'store']);
Route::get('/profil/{ref}', [UserController::class, 'getProfileRef']);
Route::get('/carte/{isbn}', [CarteController::class, 'getBookByIsbn']);
Route::get('/cautare', [CarteController::class, 'paginaCautare'])->name('search');
Route::post('/contact', [Controller::class, 'sendContactMail']);
Route::post('/checkout', [ComandaController::class, 'checkout']);
Route::post('/mail', [UserController::class, 'sendMail']);
Route::get('/verify/{token}', [UserController::class, 'verifyMail']);
Route::get('/reset/{token}', [UserController::class, 'resetPasswordRedirect']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/user', [UserController::class, 'store']);
Route::post('/reset-request', [UserController::class, 'sendPasswordRequest']);
Route::put('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/search', [CarteController::class, 'search']);
Route::get('/client-autentificat', [ClientController::class, 'getUserData']);
Route::get('/latest', [CarteController::class, 'getLatestCarti']);
Route::get('/discounted', [CarteController::class, 'getDiscountedCarti']);
Route::get('/discounts', [DiscountController::class, 'index']);
Route::post('/returnari', [CategorieController::class, 'store']);
Route::post('/donatii', [CategorieController::class, 'store']);

Route::prefix('filtre')->group(function () {
    Route::get('/', [CarteController::class, 'getFilters']);
    Route::post('/', [CarteController::class, 'queryBuilder']);
});

Route::prefix('clienti')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{id}', [ClientController::class, 'show']);
    Route::put('/', [ClientController::class, 'update']);
    Route::post('/', [ClientController::class, 'store']);
    Route::delete('/{id}', [ClientController::class, 'destroy']);
    Route::get('/user', [ClientController::class, 'userData']);
    Route::get('/comenzi', [ClientController::class, 'comenzi']);
    Route::get('/favorite', [ClientController::class, 'favorite']);
    Route::get('/cos', [ClientController::class, 'userData']);
});

Route::prefix('reviewuri')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/carte/{id}', [ReviewController::class, 'getByBookId']);
    Route::get('/{id}', [ReviewController::class, 'show']);
    Route::post('/', [ReviewController::class, 'store']);
});

Route::prefix('carti')->group(function () {
    Route::get('/', [CarteController::class, 'index']);
    Route::get('/recomandari/{id}', [CarteController::class, 'getRecommandations']);
    Route::get('/{id}', [CarteController::class, 'show']);
    Route::put('/', [CarteController::class, 'update']);
    Route::post('/', [CarteController::class, 'store']);
    Route::delete('/{id}', [CarteController::class, 'destroy']);
    Route::get('/categorii/{id}', [CarteController::class, 'categorii']);
    Route::get('/reviewuri/{id}', [CarteController::class, 'reviewuri']);
});

Route::prefix('carti-comanda')->group(function () {
    Route::get('/', [CarteComandaController::class, 'index']);
    Route::get('/{id}', [CarteComandaController::class, 'show']);
    Route::put('/', [CarteComandaController::class, 'update']);
    Route::post('/', [CarteComandaController::class, 'store']);
    Route::delete('/{id}', [CarteComandaController::class, 'destroy']);
});

Route::prefix('categorii')->group(function () {
    Route::get('/', [CategorieController::class, 'index']);
    Route::get('/{id}', [CategorieController::class, 'show']);
    Route::put('/', [CategorieController::class, 'update']);
    Route::post('/', [CategorieController::class, 'store']);
    Route::delete('/{id}', [CategorieController::class, 'destroy']);
    Route::get('/carti/{id}', [CategorieController::class, 'carti']);
});

Route::prefix('cos')->group(function () {
    Route::post('/', [CarteCosController::class, 'store']);
    Route::put('/', [CarteCosController::class, 'update']);
    Route::delete('/{id}', [CarteCosController::class, 'destroy']);
    Route::get('/', [CarteCosController::class, 'index']);
});

Route::prefix('import')->group(function () {
    Route::get('/carti', [ImportController::class, 'importCarti']);
    Route::get('/categorii', [ImportController::class, 'importCategorii']);
    Route::get('/useri', [ImportController::class, 'importUseri']);
    Route::get('/reviews', [ImportController::class, 'importReviews']);
    Route::get('/discounts', [ImportController::class, 'importDiscounts']);
});
