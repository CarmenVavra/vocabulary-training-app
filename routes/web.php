<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HangmanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\VocabularyVocabularyController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
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

/* Route::get('/', function () {
    return view('welcome');
});
 */
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', [LanguageController::class, 'index'])->name('get.language.index');
Route::post('/home', [LanguageController::class, 'index'])->name('post.language.index');
Route::post('/language/cookie', [LanguageController::class, 'setCookie'])->name('language.setCookie');
Route::get('/language', [LanguageController::class, 'create'])->name('language.create');
Route::post('/language', [LanguageController::class, 'store'])->name('language.store');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit'); 

Route::get('/profile', [UserController::class, 'profile'] )->name('user.profile');
Route::put('/user/{user}', [UserController::class, 'update'] )->name('user.update');

Route::middleware('auth')->group(function(){

    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome.index');
    Route::post('/welcome', [WelcomeController::class, 'index'])->name('welcome.index');

    Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
    Route::get('/vocabulary/{vocabulary}/edit', [VocabularyController::class, 'edit'])->name('vocabulary.edit');
    Route::post('/vocabulary', [VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::put('/vocabulary/{vocabularies}', [VocabularyController::class, 'update'])->name('vocabulary.update');
    Route::delete('/vocabulary/{vocabulary}', [VocabularyController::class, 'destroy'])->name('vocabulary.delete');

    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
});


Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz', [QuizController::class, 'filterSelect'])->name('quiz.filter.select');

Route::get('/pair', [PairController::class, 'index'])->name('pair.index');
Route::post('/pair', [PairController::class, 'filterSelect'])->name('pair.filter.select');

Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
Route::post('/learning', [LearningController::class, 'filterSelect'])->name('learning.filter.select');

Route::get('/hangman', [HangmanController::class, 'index'])->name('hangman.index');
Route::post('/hangman', [HangmanController::class, 'filterSelect'])->name('hangman.filter.select');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


